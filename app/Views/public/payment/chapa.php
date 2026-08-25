<!-- app/Views/public/payment/chapa.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapa Payment - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .payment-card { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .payment-card .icon { font-size: 4rem; color: #4caf50; }
        .btn-pay { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; width: 100%; }
        .btn-pay:hover { background: #388e3c; color: #fff; }
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
                <i class="fas fa-credit-card"></i>
            </div>
            <h2 class="mt-3">Chapa Payment</h2>
            <p class="text-muted">Order #<?= $order['order_number'] ?></p>
            
            <div class="amount" style="font-size: 2rem; font-weight: 700; color: #1a2e1a;">
                ETB <?= number_format($amount, 2) ?>
            </div>
            <p class="text-muted">Reference: <strong><?= $txRef ?></strong></p>

            <div class="mt-4">
                <button class="btn-pay" onclick="processChapaPayment()">
                    <i class="fas fa-lock me-2"></i>Pay with Chapa
                </button>
            </div>

            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>
                    Secured by Chapa Payment Gateway
                </small>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function processChapaPayment() {
    window.location.href = '<?= $redirectUrl ?>?tx_ref=<?= $txRef ?>';
}
</script>
</body>
</html>