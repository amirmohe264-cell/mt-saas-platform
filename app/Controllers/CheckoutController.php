<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;
use App\Models\DeliveryTrackingModel;

class CheckoutController extends BaseController
{
    protected $cartModel;
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentModel;
    protected $deliveryTrackingModel;

    public function __construct()
    {
        helper('email');
        
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
        $this->deliveryTrackingModel = new DeliveryTrackingModel();
    }

    // ============================================
    // CHECKOUT PAGE
    // ============================================

    public function index()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login to checkout.');
        }

        $cartItems = $this->cartModel->getCartByCustomer($customerId);

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        $itemCount = 0;
        foreach ($cartItems as &$item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
            $subtotal += $item['subtotal'];
            $itemCount += $item['quantity'];
        }

        $shipping = ($subtotal > 50) ? 0 : 5.00;
        $tax = $subtotal * 0.08;
        $grandTotal = $subtotal + $shipping + $tax;

        $customerData = [
            'first_name' => session()->get('first_name') ?? '',
            'last_name' => session()->get('last_name') ?? '',
            'email' => session()->get('email') ?? '',
            'phone' => session()->get('phone') ?? '',
        ];

        return view('public/checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'grandTotal' => $grandTotal,
            'itemCount' => $itemCount,
            'customer' => $customerData,
        ]);
    }

    // ============================================
    // PROCESS ORDER
    // ============================================

    public function process()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login to checkout.');
        }

        $cartItems = $this->cartModel->getCartByCustomer($customerId);

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        // Get form data
        $firstName = $this->request->getPost('first_name');
        $lastName = $this->request->getPost('last_name');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        $address = $this->request->getPost('address');
        $city = $this->request->getPost('city');
        $postalCode = $this->request->getPost('postal_code');
        $paymentMethod = $this->request->getPost('payment_method');

        // Validate
        if (empty($firstName) || empty($lastName) || empty($address) || empty($city)) {
            return redirect()->back()->with('error', 'Please fill in all required fields (First Name, Last Name, Address, City).');
        }

        if (empty($paymentMethod)) {
            return redirect()->back()->with('error', 'Please select a payment method.');
        }

        // Calculate totals
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $shipping = ($totalAmount > 50) ? 0 : 5.00;
        $tax = $totalAmount * 0.08;
        $grandTotal = $totalAmount + $shipping + $tax;

        $firstItem = $this->productModel->find($cartItems[0]['product_id']);
        $tenantId = $firstItem['tenant_id'] ?? 1;

        // Generate order number
        $orderNumber = 'ORD-' . date('Y-m-d') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

        // ✅ Match your actual OrderModel columns
        $orderData = [
            'tenant_id' => $tenantId,
            'customer_id' => $customerId,
            'order_number' => $orderNumber,
            'total_amount' => $grandTotal,
            'shipping_address' => $address,
            'city' => $city,
            'postal_code' => $postalCode ?: null,
            'phone' => $phone,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'notes' => null,
        ];

        log_message('debug', 'Order Data: ' . print_r($orderData, true));

        $orderId = $this->orderModel->insert($orderData);

        if (!$orderId) {
            return redirect()->back()->with('error', 'Failed to create order. Please try again.');
        }

        // ✅ FIX: Create order items with 'total'
        foreach ($cartItems as $item) {
    $this->orderItemModel->insert([
        'order_id'   => $orderId,
        'product_id' => $item['product_id'],
        'quantity'   => $item['quantity'],
        'price'      => $item['price'],
        'total'      => $item['price'] * $item['quantity'],  // ✅ ADD THIS
    ]);

    // Reduce product stock
    $product = $this->productModel->find($item['product_id']);
    if ($product) {
        $newQuantity = $product['quantity'] - $item['quantity'];
        $this->productModel->update($item['product_id'], ['quantity' => $newQuantity]);
    }
}

        // Clear the cart
        $this->cartModel->where('customer_id', $customerId)->delete();
        session()->set('cart_count', 0);

        // ✅ Send order confirmation email
        $customer = $this->getCustomerInfo($customerId);
        if ($customer && !empty($customer['email'])) {
            $orderData['order_number'] = $orderNumber;
            $orderData['total_amount'] = $grandTotal;
            $orderData['order_status'] = 'pending';
            sendOrderConfirmation($customer['email'], $orderData);
        }

        // Process payment based on method
        return $this->processPayment($orderId, $paymentMethod, $grandTotal);
    }

    // ============================================
    // GET CUSTOMER INFO
    // ============================================

    private function getCustomerInfo($customerId)
    {
        $customerModel = new \App\Models\CustomerModel();
        return $customerModel->find($customerId);
    }

    // ============================================
    // PROCESS PAYMENT
    // ============================================

    private function processPayment($orderId, $paymentMethod, $amount)
    {
        $order = $this->orderModel->find($orderId);

        // Calculate fees
        $platformFee = $amount * 0.10;
        $deliveryFee = 5.00;
        $storeOwnerAmount = $amount - $platformFee;

        // Create payment record (ESCROW)
        $paymentData = [
            'order_id' => $orderId,
            'tenant_id' => $order['tenant_id'],
            'customer_id' => $order['customer_id'],
            'amount' => $amount,
            'platform_fee' => $platformFee,
            'delivery_fee' => $deliveryFee,
            'store_owner_amount' => $storeOwnerAmount,
            'payment_method' => $paymentMethod,
            'transaction_id' => 'TXN-' . time() . '-' . $orderId,
            'status' => 'pending',
            'escrow_held' => true,
            'paid_at' => date('Y-m-d H:i:s'),
        ];

        $paymentId = $this->paymentModel->insert($paymentData);
        
        if ($paymentId) {
            $this->orderModel->update($orderId, ['payment_id' => $paymentId]);
        }

        // Create delivery tracking
        $this->deliveryTrackingModel->insert([
            'order_id' => $orderId,
            'tenant_id' => $order['tenant_id'],
            'status' => 'pending',
            'confirmed_by_customer' => false,
        ]);

        // Notify store owner
        $this->notifyStoreOwner($order['tenant_id'], $orderId);

        switch ($paymentMethod) {
            case 'telebirr':
                return $this->telebirrPayment($order, $amount);
            case 'chapa':
                return $this->chapaPayment($order, $amount);
            case 'bank':
                return $this->bankPayment($order);
            case 'cod':
                return $this->codPayment($order);
            default:
                return redirect()->to('/checkout')->with('error', 'Invalid payment method.');
        }
    }

    // ============================================
    // 1. TELEBIRR PAYMENT
    // ============================================

    private function telebirrPayment($order, $amount)
    {
        $paymentRef = 'TEL-' . time() . '-' . $order['id'];
        
        $this->orderModel->update($order['id'], [
            'payment_reference' => $paymentRef,
            'payment_status' => 'pending',
        ]);

        $telebirrMessage = "To complete payment:\n"
                          . "1. Dial *127#\n"
                          . "2. Select 'Pay'\n"
                          . "3. Enter Merchant Code: SHOPEASE\n"
                          . "4. Enter Amount: " . number_format($amount, 2) . " ETB\n"
                          . "5. Enter Reference: " . $paymentRef . "\n"
                          . "6. Confirm payment\n\n"
                          . "After payment, click 'I Have Paid' below.";

        return view('public/payment/telebirr', [
            'order' => $order,
            'paymentRef' => $paymentRef,
            'amount' => $amount,
            'message' => $telebirrMessage,
        ]);
    }

    // ============================================
    // 2. CHAPA PAYMENT
    // ============================================

    private function chapaPayment($order, $amount)
    {
        $chapaSecretKey = getenv('CHAPA_SECRET_KEY') ?: 'CHASECK_TEST-xxxxxxxxxxxxxxxx';
        $chapaApiUrl = 'https://api.chapa.co/v1/transaction/initialize';
        
        $txRef = 'CHAPA-' . time() . '-' . $order['id'];

        $this->orderModel->update($order['id'], [
            'payment_reference' => $txRef,
            'payment_status' => 'pending',
        ]);

        $postData = [
            'amount' => $amount,
            'currency' => 'ETB',
            'email' => session()->get('email'),
            'first_name' => session()->get('first_name'),
            'last_name' => session()->get('last_name'),
            'tx_ref' => $txRef,
            'callback_url' => base_url('payment/chapa/callback'),
            'return_url' => base_url('payment/chapa/success'),
            'customization' => [
                'title' => 'ShopEase Order #' . $order['order_number'],
                'description' => 'Payment for order #' . $order['order_number'],
            ]
        ];

        if ($chapaSecretKey !== 'CHASECK_TEST-xxxxxxxxxxxxxxxx') {
            $ch = curl_init($chapaApiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $chapaSecretKey,
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200) {
                $result = json_decode($response, true);
                if (isset($result['data']['checkout_url'])) {
                    return redirect()->away($result['data']['checkout_url']);
                }
            }
        }

        return view('public/payment/chapa', [
            'order' => $order,
            'txRef' => $txRef,
            'amount' => $amount,
            'redirectUrl' => base_url('payment/chapa/success'),
        ]);
    }

    // ============================================
    // 3. BANK TRANSFER
    // ============================================

    private function bankPayment($order)
    {
        $bankDetails = [
            'bank_name' => 'Commercial Bank of Ethiopia',
            'account_name' => 'ShopEase Platform',
            'account_number' => '1000 1234 5678',
            'branch' => 'Addis Ababa',
            'reference' => 'ORDER-' . $order['order_number'],
        ];

        $this->orderModel->update($order['id'], [
            'payment_status' => 'pending',
        ]);

        return view('public/payment/bank', [
            'order' => $order,
            'bankDetails' => $bankDetails,
            'amount' => $order['total_amount'],
        ]);
    }

    // ============================================
    // 4. CASH ON DELIVERY
    // ============================================

    private function codPayment($order)
    {
        $this->orderModel->update($order['id'], [
            'payment_status' => 'cod',
            'order_status' => 'confirmed',
        ]);

        return redirect()->to('/order-confirmation/' . $order['id'])
                        ->with('success', '✅ Order placed successfully! Pay on delivery.');
    }

    // ============================================
    // CHAPA CALLBACK
    // ============================================

    public function chapaCallback()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (isset($input['data']['tx_ref'])) {
            $txRef = $input['data']['tx_ref'];
            $status = $input['data']['status'] ?? 'failed';
            
            $order = $this->orderModel->where('payment_reference', $txRef)->first();
            
            if ($order) {
                if ($status === 'success') {
                    $this->orderModel->update($order['id'], [
                        'payment_status' => 'paid',
                        'order_status' => 'confirmed',
                        'paid_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    $payment = $this->paymentModel->where('order_id', $order['id'])->first();
                    if ($payment) {
                        $this->paymentModel->update($payment['id'], [
                            'status' => 'paid',
                            'escrow_held' => true,
                        ]);
                    }
                } else {
                    $this->orderModel->update($order['id'], [
                        'payment_status' => 'failed',
                    ]);
                }
            }
        }
        
        return $this->response->setJSON(['status' => 'ok']);
    }

    // ============================================
    // CHAPA SUCCESS
    // ============================================

    public function chapaSuccess()
    {
        $txRef = $this->request->getGet('tx_ref');
        
        if ($txRef) {
            $order = $this->orderModel->where('payment_reference', $txRef)->first();
            
            if ($order) {
                $chapaSecretKey = getenv('CHAPA_SECRET_KEY') ?: 'CHASECK_TEST-xxxxxxxxxxxxxxxx';
                $ch = curl_init('https://api.chapa.co/v1/transaction/verify/' . $txRef);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $chapaSecretKey,
                ]);
                $response = curl_exec($ch);
                curl_close($ch);
                
                $result = json_decode($response, true);
                
                if (isset($result['data']['status']) && $result['data']['status'] === 'success') {
                    $this->orderModel->update($order['id'], [
                        'payment_status' => 'paid',
                        'order_status' => 'confirmed',
                        'paid_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    $payment = $this->paymentModel->where('order_id', $order['id'])->first();
                    if ($payment) {
                        $this->paymentModel->update($payment['id'], [
                            'status' => 'paid',
                            'escrow_held' => true,
                        ]);
                    }
                    
                    return redirect()->to('/order-confirmation/' . $order['id'])
                                    ->with('success', '✅ Payment successful! Thank you for your order.');
                }
            }
        }
        
        return redirect()->to('/orders')->with('error', 'Payment verification failed. Please contact support.');
    }

    // ============================================
    // TELEBIRR CONFIRMATION
    // ============================================

    public function telebirrConfirm($orderId)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $order = $this->orderModel->where('id', $orderId)
                                  ->where('customer_id', $customerId)
                                  ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Order not found.');
        }

        if ($order['payment_status'] === 'paid') {
            return redirect()->to('/order-confirmation/' . $orderId)
                            ->with('info', 'Payment already confirmed.');
        }

        $this->orderModel->update($orderId, [
            'payment_status' => 'pending_verification',
        ]);

        return redirect()->to('/order-confirmation/' . $orderId)
                        ->with('info', '✅ Payment confirmation received! We will verify your payment shortly.');
    }

    // ============================================
    // ORDER CONFIRMATION
    // ============================================

    public function confirmation($orderId)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');
        
        if (!$customerId) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $order = $this->orderModel->where('id', $orderId)
                                  ->where('customer_id', $customerId)
                                  ->first();

        if (!$order) {
            return redirect()->to('/orders')->with('error', 'Order not found.');
        }

        $orderItems = $this->orderItemModel->where('order_id', $orderId)
                                          ->join('products', 'products.id = order_items.product_id')
                                          ->findAll();

        return view('public/order_confirmation', [
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }

    // ============================================
    // NOTIFICATION
    // ============================================

    private function notifyStoreOwner($tenantId, $orderId)
    {
        log_message('info', "🔔 New order #{$orderId} for tenant #{$tenantId}. Payment confirmed.");
    }
}