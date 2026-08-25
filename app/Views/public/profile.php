<!-- app/Views/public/profile.php -->
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
    <title>My Profile - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { padding-top: 80px; background: #f8f9fa; }
        .profile-card { background: #fff; border-radius: 12px; padding: 30px; border: 1px solid #e8f0e8; max-width: 600px; margin: 0 auto; }
        .btn-save { background: #4caf50; color: #fff; border: none; border-radius: 30px; padding: 12px 40px; font-weight: 600; }
        .btn-save:hover { background: #388e3c; color: #fff; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top" style="background: #1a2e1a !important;">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <a href="/dashboard" class="text-white"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="profile-card">
            <h4><i class="fas fa-user me-2 text-success"></i>My Profile</h4>
            <hr>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/profile/update" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= $customer['first_name'] ?? '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= $customer['last_name'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="<?= $customer['email'] ?? '' ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="<?= $customer['phone'] ?? '' ?>">
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Update Profile</button>
            </form>

            <hr>
            <h5>Change Password</h5>
            <form action="/profile/change-password" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn-save"><i class="fas fa-save me-2"></i>Change Password</button>
            </form>
        </div>
    </div>
</section>

</body>
</html>