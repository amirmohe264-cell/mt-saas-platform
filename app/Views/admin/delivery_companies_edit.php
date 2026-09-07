<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Delivery Company - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .form-control, .form-select { border-radius: 10px; padding: 12px 15px; border: 2px solid #e8f0e8; }
        .form-control:focus, .form-select:focus { border-color: #4caf50; box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25); }
        .btn-success { border-radius: 10px; padding: 12px 30px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="fas fa-edit me-2 text-success"></i>Edit Delivery Company</h4>
            <a href="/admin/delivery-companies" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card p-4">
            <form id="companyForm" action="/admin/delivery-companies/update/<?= $company['id'] ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter company name" required value="<?= esc($company['name']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="company@email.com" required value="<?= esc($company['email']) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required value="<?= esc($company['phone']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?= $company['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="active" <?= $company['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $company['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password (optional)</label>
                    <input type="password" name="password" id="newPassword" class="form-control" placeholder="Leave blank to keep current password" autocomplete="new-password" minlength="8">
                    <small class="text-muted">Enter new password only if you want to change it. Must be at least 8 characters.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="passwordConfirmation" class="form-control" placeholder="Confirm the new password" autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Address</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="Enter company address"><?= esc($company['address']) ?></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Update Company
                    </button>
                    <a href="/admin/delivery-companies" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('companyForm').addEventListener('submit', function (event) {
            const password = document.getElementById('newPassword').value;
            const confirmation = document.getElementById('passwordConfirmation').value;

            if (!password) {
                return;
            }

            if (password.length < 8) {
                event.preventDefault();
                alert('Password must be at least 8 characters.');
                return;
            }

            if (password !== confirmation) {
                event.preventDefault();
                alert('The password confirmation does not match.');
            }
        });
    </script>
</body>
</html>