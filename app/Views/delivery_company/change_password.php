<?php $active_menu = 'change-password'; ?>
<!-- app/Views/delivery_company/change_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding-left: 280px;
            padding-top: 80px;
            transition: padding-left 0.3s ease;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1050;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand i { color: #4caf50; }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 8px;
            transition: 0.3s;
            background: none;
            border: none;
            text-decoration: none;
        }
        .icon-btn:hover { color: #4caf50; transform: scale(1.1); }

        /* Sidebar */
        .sidebar-wrapper {
            position: fixed;
            top: 80px;
            left: 0;
            width: 280px;
            height: calc(100vh - 80px);
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e8f0e8;
            padding: 20px 15px;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
        .sidebar-wrapper::-webkit-scrollbar-track { background: #e8f0e8; }

        .sidebar-wrapper.collapsed { width: 70px; }
        .sidebar-wrapper.collapsed .company-name,
        .sidebar-wrapper.collapsed .company-email,
        .sidebar-wrapper.collapsed .sidebar-category { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li { padding: 10px; justify-content: center; }
        .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: none; }
        .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 0; font-size: 1.2rem; }
        .sidebar-wrapper.collapsed .sidebar-menu li { position: relative; }
        .sidebar-wrapper.collapsed .sidebar-menu li:hover::after {
            content: attr(data-tooltip);
            position: absolute; left: 100%; top: 50%; transform: translateY(-50%);
            background: #1a2e1a; color: #fff; padding: 5px 12px; border-radius: 6px;
            font-size: 0.8rem; white-space: nowrap; z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2); margin-left: 8px;
        }
        .sidebar-wrapper.collapsed .company-avatar { width: 45px; height: 45px; font-size: 1.2rem; }

        body.sidebar-collapsed { padding-left: 70px; }

        .sidebar-card .company-avatar {
            width: 70px; height: 70px; border-radius: 50%;
            background: #4caf50; color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin: 0 auto 10px;
            transition: all 0.3s ease;
        }
        .sidebar-card .company-name {
            text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem;
        }
        .sidebar-card .company-email {
            text-align: center; font-size: 0.8rem; color: #888;
        }

        .toggle-sidebar-btn {
            background: #4caf50; color: #fff; border: none; border-radius: 8px;
            padding: 8px 12px; font-size: 1rem; cursor: pointer; width: 100%;
            margin-bottom: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .toggle-sidebar-btn:hover { background: #388e3c; }

        .sidebar-category {
            font-size: 0.65rem; font-weight: 700; color: #aaa;
            text-transform: uppercase; letter-spacing: 0.5px;
            padding: 15px 10px 5px; border-top: 1px solid #f0f0f0; margin-top: 5px;
        }
        .sidebar-category:first-child { border-top: none; margin-top: 0; padding-top: 5px; }

        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li {
            padding: 10px 12px; border-radius: 8px; cursor: pointer;
            color: #555; font-size: 0.9rem; display: flex; align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar-menu li:hover { background: #f0f8f0; color: #4caf50; }
        .sidebar-menu li.active { background: #f0f8f0; color: #4caf50; font-weight: 600; }
        .sidebar-menu li i { margin-right: 12px; width: 20px; text-align: center; font-size: 1rem; }
        .sidebar-menu li .menu-text { flex: 1; }
        .sidebar-menu li a { color: inherit; text-decoration: none; display: flex; align-items: center; width: 100%; }

        /* Main Content */
        .main-content {
            margin-left: 0;
            padding: 20px 30px;
            margin-top: 0;
            min-height: calc(100vh - 160px);
        }

        /* Page Header */
        .page-header {
            background: #f8f9fa;
            color: #1a2e1a;
            padding: 20px 0 20px;
            border-bottom: 1px solid #e8f0e8;
        }
        .page-header h2 {
            font-weight: 700;
            color: #1a2e1a;
        }
        .page-header .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        .page-header .breadcrumb a {
            color: #4caf50;
            text-decoration: none;
        }
        .page-header .breadcrumb .active {
            color: #888;
        }

        /* Form Card */
        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e8f0e8;
            max-width: 600px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e8f0e8;
        }
        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
        }
        .btn-success {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }

        /* Password Strength - FIXED */
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s ease;
        }
        .password-strength.weak {
            background: #dc3545;
            width: 25%;
        }
        .password-strength.medium {
            background: #ffc107;
            width: 50%;
        }
        .password-strength.strong {
            background: #28a745;
            width: 75%;
        }
        .password-strength.very-strong {
            background: #17a2b8;
            width: 100%;
        }
        .password-requirements {
            font-size: 0.8rem;
            color: #888;
            margin-top: 5px;
        }
        .password-requirements .req-met {
            color: #28a745;
        }
        .password-requirements .req-unmet {
            color: #dc3545;
        }

        @media (max-width: 992px) {
            body { padding-left: 0; }
            .sidebar-wrapper {
                position: relative; top: 0; width: 100%; height: auto;
                border-right: none; border-bottom: 1px solid #e8f0e8;
            }
            .sidebar-wrapper.collapsed { width: 100%; }
            .sidebar-wrapper.collapsed .sidebar-menu li { justify-content: flex-start; }
            .sidebar-wrapper.collapsed .sidebar-menu li .menu-text { display: inline; }
            .sidebar-wrapper.collapsed .sidebar-menu li i { margin-right: 12px; }
            .sidebar-wrapper.collapsed .company-name,
            .sidebar-wrapper.collapsed .company-email,
            .sidebar-wrapper.collapsed .sidebar-category { display: block; }
            body.sidebar-collapsed { padding-left: 0; }
            .main-content { padding: 15px; }
        }
    </style>
</head>
<body id="mainBody">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/delivery/dashboard">
            <i class="fas fa-truck"></i> ShopEase Delivery
        </a>
        <div class="d-flex align-items-center ms-auto">
            <span class="text-white me-3 d-none d-md-inline">
                <i class="fas fa-store me-1"></i><?= session()->get('delivery_company_name') ?? 'Company' ?>
            </span>
            <a href="/delivery/logout" class="icon-btn">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar-wrapper" id="sidebarWrapper">
    <div class="sidebar-card">
        <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <div class="company-avatar">
            <i class="fas fa-truck"></i>
        </div>
        <div class="company-name"><?= session()->get('delivery_company_name') ?? 'Delivery Company' ?></div>
        <div class="company-email"><?= session()->get('delivery_company_email') ?? '' ?></div>

        <div class="sidebar-category">Main</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li onclick="location.href='/delivery/orders'" data-tooltip="Delivery Orders">
                <i class="fas fa-list"></i>
                <span class="menu-text">Delivery Orders</span>
            </li>
             <li class="<?= $active_menu == 'assign' ? 'active' : '' ?>" onclick="location.href='/delivery/assign'" data-tooltip="Assign Delivery">
                <i class="fas fa-user-plus"></i>
                <span class="menu-text">Assign Delivery</span>
            </li>
            <li onclick="location.href='/delivery/active'" data-tooltip="Active Deliveries">
                <i class="fas fa-spinner"></i>
                <span class="menu-text">Active Deliveries</span>
            </li>
            <li onclick="location.href='/delivery/completed'" data-tooltip="Completed Deliveries">
                <i class="fas fa-check-circle"></i>
                <span class="menu-text">Completed Deliveries</span>
            </li>
        </ul>

        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li onclick="location.href='/delivery/agents'" data-tooltip="Delivery Agents">
                <i class="fas fa-users"></i>
                <span class="menu-text">Delivery Agents</span>
            </li>
            <li onclick="location.href='/delivery/history'" data-tooltip="Delivery History">
                <i class="fas fa-history"></i>
                <span class="menu-text">Delivery History</span>
            </li>
        </ul>

        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li class="active" onclick="location.href='/delivery/change-password'" data-tooltip="Change Password">
                <i class="fas fa-key"></i>
                <span class="menu-text">Change Password</span>
            </li>
            <li>
                <a href="/delivery/logout" data-tooltip="Logout">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Page Header -->
<section class="page-header">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-key me-2 text-warning"></i>Change Password</h2>
                <nav class="breadcrumb">
                    <a href="/delivery/dashboard">Dashboard</a>
                    <span class="mx-2">/</span>
                    <span class="active">Change Password</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="main-content">
    <div class="container-fluid px-4">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('warning')): ?>
            <div class="alert alert-warning"><?= session()->getFlashdata('warning') ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form id="passwordForm" onsubmit="updatePassword(event)">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" id="currentPassword" class="form-control" placeholder="Enter current password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('currentPassword')">
                            <i class="fas fa-eye" id="currentPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" id="newPassword" class="form-control" placeholder="Enter new password" required onkeyup="checkPasswordStrength(this.value)">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('newPassword')">
                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="passwordStrength"></div>
                    <div class="password-requirements" id="passwordRequirements">
                        <span id="reqLength" class="req-unmet"><i class="fas fa-circle"></i> At least 8 characters</span><br>
                        <span id="reqUppercase" class="req-unmet"><i class="fas fa-circle"></i> At least 1 uppercase letter</span><br>
                        <span id="reqLowercase" class="req-unmet"><i class="fas fa-circle"></i> At least 1 lowercase letter</span><br>
                        <span id="reqNumber" class="req-unmet"><i class="fas fa-circle"></i> At least 1 number</span><br>
                        <span id="reqSpecial" class="req-unmet"><i class="fas fa-circle"></i> At least 1 special character</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm new password" required onkeyup="checkPasswordMatch()">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirmPassword')">
                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                        </button>
                    </div>
                    <small id="passwordMatchMsg" class="text-muted"></small>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Update Password
                    </button>
                    <a href="/delivery/dashboard" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + 'Icon');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function toggleSidebar() {
    var wrapper = document.getElementById('sidebarWrapper');
    var body = document.getElementById('mainBody');
    wrapper.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
}

function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    const reqLength = document.getElementById('reqLength');
    const reqUppercase = document.getElementById('reqUppercase');
    const reqLowercase = document.getElementById('reqLowercase');
    const reqNumber = document.getElementById('reqNumber');
    const reqSpecial = document.getElementById('reqSpecial');
    
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    
    updateRequirement(reqLength, hasLength);
    updateRequirement(reqUppercase, hasUppercase);
    updateRequirement(reqLowercase, hasLowercase);
    updateRequirement(reqNumber, hasNumber);
    updateRequirement(reqSpecial, hasSpecial);
    
    let strength = 0;
    if (hasLength) strength++;
    if (hasUppercase) strength++;
    if (hasLowercase) strength++;
    if (hasNumber) strength++;
    if (hasSpecial) strength++;
    
    strengthBar.className = 'password-strength';
    if (password.length === 0) {
        strengthBar.style.width = '0%';
        strengthBar.style.background = 'transparent';
        strengthBar.textContent = '';
    } else if (strength <= 2) {
        strengthBar.classList.add('weak');
        strengthBar.textContent = 'Weak';
    } else if (strength <= 3) {
        strengthBar.classList.add('medium');
        strengthBar.textContent = 'Medium';
    } else if (strength <= 4) {
        strengthBar.classList.add('strong');
        strengthBar.textContent = 'Strong';
    } else {
        strengthBar.classList.add('very-strong');
        strengthBar.textContent = 'Very Strong';
    }
    
    checkPasswordMatch();
}

function updateRequirement(element, met) {
    const text = element.textContent.replace(/[✓✗]/g, '').trim();
    if (met) {
        element.className = 'req-met';
        element.innerHTML = '<i class="fas fa-check-circle"></i> ' + text;
    } else {
        element.className = 'req-unmet';
        element.innerHTML = '<i class="fas fa-circle"></i> ' + text;
    }
}

function checkPasswordMatch() {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const msg = document.getElementById('passwordMatchMsg');
    
    if (confirmPassword.length === 0) {
        msg.textContent = '';
        msg.className = 'text-muted';
        return;
    }
    
    if (newPassword === confirmPassword) {
        msg.textContent = '✅ Passwords match!';
        msg.className = 'text-success';
    } else {
        msg.textContent = '❌ Passwords do not match!';
        msg.className = 'text-danger';
    }
}

function updatePassword(event) {
    event.preventDefault();
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword) {
        alert('Please enter your current password.');
        return;
    }
    
    if (!newPassword || newPassword.length < 8) {
        alert('Password must be at least 8 characters.');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('New passwords do not match!');
        return;
    }
    
    const formData = new URLSearchParams();
    formData.append('current_password', currentPassword);
    formData.append('new_password', newPassword);

    fetch('/delivery/change-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
            document.getElementById('passwordStrength').className = 'password-strength';
            document.getElementById('passwordStrength').style.width = '0%';
            document.getElementById('passwordMatchMsg').textContent = '';
            document.querySelectorAll('.password-requirements span').forEach(el => {
                el.className = 'req-unmet';
                const text = el.textContent.replace(/[✓✗]/g, '').trim();
                el.innerHTML = '<i class="fas fa-circle"></i> ' + text;
            });
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update password.');
    });
}
</script>
</body>
</html>