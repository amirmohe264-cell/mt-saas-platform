<?php

namespace App\Controllers;

use App\Models\CartModel;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;
use App\Models\DeliveryTrackingModel;
use App\Models\CustomerModel;

class CheckoutController extends BaseController
{
    protected $cartModel;
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $paymentModel;
    protected $deliveryTrackingModel;
    protected $customerModel;

    public function __construct()
    {
        helper('email');
        
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->paymentModel = new PaymentModel();
        $this->deliveryTrackingModel = new DeliveryTrackingModel();
        $this->customerModel = new CustomerModel();
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

        // Get cart items
        $cartItems = $this->cartModel->getCartByCustomer($customerId);

        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        // Get customer data from database
        $customer = $this->customerModel->find($customerId);
            $db = \Config\Database::connect();
    $settingsRows = $db->table('settings')
        ->whereIn('setting_key', ['chapa_enabled', 'telebirr_enabled', 'cod_enabled'])
        ->get()
        ->getResultArray();

    $gatewaySettings = [
        'chapa_enabled' => '1',
        'telebirr_enabled' => '1',
        'cod_enabled' => '1',
    ];
    foreach ($settingsRows as $row) {
        $gatewaySettings[$row['setting_key']] = $row['setting_value'];
    }
        
        // Calculate totals
        $subtotal = 0;
        $itemCount = 0;
        foreach ($cartItems as &$item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
            $subtotal += $item['subtotal'];
            $itemCount += $item['quantity'];
        }

        // Calculate shipping, tax, total
        $shipping = ($subtotal > 50) ? 0 : 5.00;
        $tax = $subtotal * 0.08;
        $total = $subtotal + $shipping + $tax;

        // Prepare customer data for the form
        $customerData = [
            'first_name' => $customer['first_name'] ?? session()->get('first_name') ?? '',
            'last_name' => $customer['last_name'] ?? session()->get('last_name') ?? '',
            'email' => $customer['email'] ?? session()->get('email') ?? '',
            'phone' => $customer['phone'] ?? session()->get('phone') ?? '',
            'address' => $customer['address'] ?? '',
            'city' => $customer['city'] ?? '',
            'postal_code' => $customer['postal_code'] ?? '',
        ];

        return view('public/checkout', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'itemCount' => $itemCount,
            'user' => $customerData,  // For the form fields
            'customer' => $customerData,
             'gatewaySettings' => $gatewaySettings,  // Alias for compatibility
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
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|min_length[2]',
            'last_name' => 'required|min_length[2]',
            'address' => 'required|min_length[5]',
            'city' => 'required|min_length[2]',
            'payment_method' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('errors', $validation->getErrors())
                ->withInput();
        }

        // Calculate totals
        $subtotal = 0;
        $orderItems = [];
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            $orderItems[] = [
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'product_image' => $item['product_image'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $itemTotal
            ];
        }

        $shippingCost = ($subtotal > 50) ? 0 : 5.00;
        $tax = $subtotal * 0.08;
        $grandTotal = $subtotal + $shippingCost + $tax;

        // Get tenant_id from first product
        $firstItem = $this->productModel->find($cartItems[0]['product_id']);
        $tenantId = $firstItem['tenant_id'] ?? 1;

        // Generate order number
        $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Insert order into database
        $orderData = [
            'tenant_id' => $tenantId,
            'customer_id' => $customerId,
            'order_number' => $orderNumber,
            'customer_name' => $firstName . ' ' . $lastName,
            'customer_email' => $email,
            'phone' => $phone,
            'total_amount' => $grandTotal,
            'subtotal' => $subtotal,
            'tax_amount' => $tax,
            'shipping_cost' => $shippingCost,
            'discount_amount' => 0,
            'shipping_address' => $address,
            'city' => $city,
            'postal_code' => $postalCode,
            'payment_method' => $paymentMethod,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_method' => 'standard',
            'notes' => null,
        ];

        log_message('debug', 'Order Data: ' . print_r($orderData, true));

        $orderId = $this->orderModel->insert($orderData);

        if (!$orderId) {
            return redirect()->back()->with('error', 'Failed to create order. Please try again.');
        }

        // Create order items
        foreach ($orderItems as $item) {
            $this->orderItemModel->insert([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
               
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['subtotal']
            ]);

            // Reduce product stock
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $newQuantity = $product['quantity'] - $item['quantity'];
                $this->productModel->update($item['product_id'], ['quantity' => $newQuantity]);
            }
        }

        // Clear cart
        $this->cartModel->where('customer_id', $customerId)->delete();
        session()->set('cart_count', 0);

        // Process payment based on method
        return $this->processPayment($orderId, $paymentMethod, $grandTotal);
    }

    // ============================================
    // PROCESS PAYMENT
    // ============================================

    private function processPayment($orderId, $paymentMethod, $amount)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->to('/cart')->with('error', 'Order not found.');
        }

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

        // Create delivery tracking
        $this->deliveryTrackingModel->insert([
            'order_id' => $orderId,
            'tenant_id' => $order['tenant_id'],
            'status' => 'pending',
            'confirmed_by_customer' => false,
        ]);

        // Notify store owner
        $this->notifyStoreOwner($order['tenant_id'], $orderId);

        // Redirect based on payment method
        if ($paymentMethod === 'cod') {
            // Cash on Delivery
            $this->orderModel->update($orderId, [
                'payment_status' => 'cod',
                'order_status' => 'confirmed',
            ]);
            
            return redirect()->to('/order-confirmation/' . $orderId)
                            ->with('success', '✅ Order placed successfully! Pay on delivery.');
        } elseif ($paymentMethod === 'telebirr') {
            // Telebirr payment
            return $this->telebirrPayment($order, $amount);
        } elseif ($paymentMethod === 'chapa') {
            // Chapa payment
            return $this->chapaPayment($order, $amount);
        } else {
            // Default - redirect to confirmation
            return redirect()->to('/order-confirmation/' . $orderId)
                            ->with('success', '✅ Order placed successfully!');
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
            'email' => $order['customer_email'] ?? session()->get('email'),
            'first_name' => $order['customer_name'] ?? session()->get('first_name'),
            'last_name' => '',
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
        
       return redirect()->to('/dashboard#orders')->with('error', 'Payment verification failed. Please contact support.');
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
            return redirect()->to('/dashboard#orders')->with('error', 'Order not found.');
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
            return redirect()->to('/dashboard#orders')->with('error', 'Order not found.');
        }

        $orderItems = $this->orderItemModel->where('order_id', $orderId)->findAll();

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
        log_message('info', "🔔 New order #{$orderId} for tenant #{$tenantId}.");
    }
}