<!-- app/Views/public/payment/telebirr.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telebirr Payment - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .payment-card { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .payment-card .icon { font-size: 4rem; color: #4caf50; }
        .payment-card .amount { font-size: 2rem; font-weight: 700; color: #1a2e1a; }
        .btn-confirm { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; width: 100%; }
        .btn-confirm:hover { background: #388e3c; color: #fff; }
        .instructions { background: #f0f8f0; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50; }
        .navbar { background: #1a2e1a !important; padding: 15px 0; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="payment-card text-center">
            <div class="icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h2 class="mt-3">Telebirr Payment</h2>
            <p class="text-muted">Order #<?= $order['order_number'] ?></p>
            
            <div class="amount">ETB <?= number_format($amount, 2) ?></div>
            <p class="text-muted">Reference: <strong><?= $paymentRef ?></strong></p>

            <div class="instructions text-start mt-4">
                <h6><i class="fas fa-info-circle me-2 text-success"></i>Payment Instructions</h6>
                <ol class="mt-2">
                    <li>Dial <strong>*127#</strong> on your mobile phone</li>
                    <li>Select <strong>"Pay"</strong> or <strong>"Send Money"</strong></li>
                    <li>Enter Merchant Code: <strong>SHOPEASE</strong></li>
                    <li>Enter Amount: <strong>ETB <?= number_format($amount, 2) ?></strong></li>
                    <li>Enter Reference: <strong><?= $paymentRef ?></strong></li>
                    <li>Confirm payment</li>
                </ol>
            </div>

            <div class="mt-4">
                <button class="btn-confirm" onclick="confirmTelebirr(<?= $order['id'] ?>)">
                    <i class="fas fa-check me-2"></i>I Have Paid
                </button>
            </div>

            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Payment will be verified within 24 hours
                </small>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmTelebirr(orderId) {
    if (confirm('Have you completed the Telebirr payment?')) {
        window.location.href = '/payment/telebirr/confirm/' + orderId;
    }
}
</script>
</body>
</html>