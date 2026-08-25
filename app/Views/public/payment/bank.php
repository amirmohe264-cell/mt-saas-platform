<!-- app/Views/public/payment/bank.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transfer - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .payment-card { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 40px; box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .bank-details { background: #f8f9fa; padding: 20px; border-radius: 8px; }
        .btn-confirm { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; width: 100%; }
        .btn-confirm:hover { background: #388e3c; color: #fff; }
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
        <div class="payment-card">
            <div class="text-center">
                <i class="fas fa-university" style="font-size: 4rem; color: #4caf50;"></i>
                <h2 class="mt-3">Bank Transfer</h2>
                <p class="text-muted">Order #<?= $order['order_number'] ?></p>
                <div class="amount" style="font-size: 2rem; font-weight: 700; color: #1a2e1a;">
                    ETB <?= number_format($amount, 2) ?>
                </div>
            </div>

            <div class="bank-details mt-4">
                <h6><i class="fas fa-info-circle me-2 text-success"></i>Bank Details</h6>
                <hr>
                <p><strong>Bank:</strong> <?= $bankDetails['bank_name'] ?></p>
                <p><strong>Account Name:</strong> <?= $bankDetails['account_name'] ?></p>
                <p><strong>Account Number:</strong> <?= $bankDetails['account_number'] ?></p>
                <p><strong>Branch:</strong> <?= $bankDetails['branch'] ?></p>
                <p><strong>Reference:</strong> <?= $bankDetails['reference'] ?></p>
            </div>

            <div class="mt-4">
                <p class="text-muted"><i class="fas fa-info-circle me-1"></i>Please use your order number as reference</p>
                <button class="btn-confirm" onclick="confirmBankPayment(<?= $order['id'] ?>)">
                    <i class="fas fa-check me-2"></i>I Have Transferred
                </button>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function confirmBankPayment(orderId) {
    if (confirm('Have you completed the bank transfer?')) {
        window.location.href = '/payment/telebirr/confirm/' + orderId;
    }
}
</script>
</body>
</html>