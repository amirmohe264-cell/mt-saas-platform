<!-- app/Views/public/address_edit.php -->
<?php
if (!session()->get('customer_id') && !session()->get('user_id')) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Address - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .form-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e8f0e8; max-width: 700px; margin: 0 auto; }
        .btn-save { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; }
        .btn-save:hover { background: #388e3c; color: #fff; }
        .btn-cancel { background: #6c757d; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-cancel:hover { background: #5a6268; color: #fff; }
        .navbar { background: #1a2e1a !important; padding: 15px 0; position: fixed; top: 0; left: 0; right: 0; z-index: 1000; }
        .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
        .navbar-brand i { color: #4caf50; }
        .icon-btn { color: #d4d4d4; font-size: 1.2rem; margin: 0 8px; transition: 0.3s; background: none; border: none; text-decoration: none; }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }
        .footer { background: #1a2e1a; color: #d4d4d4; padding: 40px 0 20px; margin-top: 40px; }
        .footer h5 { color: #fff; }
        .footer a { color: #aaa; text-decoration: none; }
        .footer a:hover { color: #4caf50; }
        .required { color: #dc3545; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="/addresses">Addresses</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Edit Address</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="/logout" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
    </div>
</nav>

<section class="py-4">
    <div class="container">
        <div class="form-card">
            <h4><i class="fas fa-edit me-2 text-success"></i>Edit Address</h4>
            <hr>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p class="mb-0"><?= $error ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/addresses/update/<?= $address['id'] ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label>Address Name <small class="text-muted">(e.g., Home, Work, Office)</small></label>
                    <input type="text" name="address_name" class="form-control" placeholder="Enter address name" value="<?= old('address_name', $address['address_name']) ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name <span class="required">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="First name" value="<?= old('first_name', $address['first_name']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Last Name <span class="required">*</span></label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last name" value="<?= old('last_name', $address['last_name']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Phone Number <span class="required">*</span></label>
                    <input type="tel" name="phone" class="form-control" placeholder="Enter phone number" value="<?= old('phone', $address['phone']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Address Line 1 <span class="required">*</span></label>
                    <input type="text" name="address_line1" class="form-control" placeholder="Street address, P.O. box" value="<?= old('address_line1', $address['address_line1']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Address Line 2 <small class="text-muted">(Optional)</small></label>
                    <input type="text" name="address_line2" class="form-control" placeholder="Apartment, suite, unit, building, floor" value="<?= old('address_line2', $address['address_line2']) ?>">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>City <span class="required">*</span></label>
                        <input type="text" name="city" class="form-control" placeholder="Enter city" value="<?= old('city', $address['city']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>State/Region <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="state" class="form-control" placeholder="Enter state/region" value="<?= old('state', $address['state']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Postal Code <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="postal_code" class="form-control" placeholder="Enter postal code" value="<?= old('postal_code', $address['postal_code']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Country</label>
                        <select name="country" class="form-control">
                            <option value="Ethiopia" <?= old('country', $address['country']) == 'Ethiopia' ? 'selected' : '' ?>>Ethiopia</option>
                            <option value="Kenya" <?= old('country', $address['country']) == 'Kenya' ? 'selected' : '' ?>>Kenya</option>
                            <option value="Nigeria" <?= old('country', $address['country']) == 'Nigeria' ? 'selected' : '' ?>>Nigeria</option>
                            <option value="South Africa" <?= old('country', $address['country']) == 'South Africa' ? 'selected' : '' ?>>South Africa</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="is_default" id="isDefault" value="1" <?= old('is_default', $address['is_default']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="isDefault">Set as default address</label>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Update Address</button>
                    <a href="/addresses" class="btn-cancel"><i class="fas fa-times me-2"></i>Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>