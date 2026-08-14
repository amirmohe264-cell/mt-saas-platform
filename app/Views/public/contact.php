<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        .navbar {
            background: #1a2e1a !important;
            padding: 15px 0;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-brand i {
            color: #4caf50;
        }
        .navbar .nav-link {
            color: #d4d4d4 !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .navbar .nav-link:hover {
            color: #4caf50 !important;
        }
        .navbar .nav-link.active {
            color: #4caf50 !important;
        }
        .search-box {
            background: #2a402a;
            border-radius: 30px;
            padding: 5px 15px;
            border: none;
            color: #fff;
        }
        .search-box::placeholder {
            color: #aaa;
        }
        .search-box:focus {
            outline: none;
            background: #2a402a;
        }
        .icon-btn {
            color: #d4d4d4;
            font-size: 1.2rem;
            margin: 0 10px;
            transition: 0.3s;
            background: none;
            border: none;
        }
        .icon-btn:hover {
            color: #4caf50;
        }
        .page-header {
            background: #1a2e1a;
            color: #fff;
            padding: 40px 0 30px;
        }
        .page-header h2 {
            font-weight: 700;
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
            color: #aaa;
        }
        .contact-info-box {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            border: 1px solid #e8f0e8;
            text-align: center;
            height: 100%;
            transition: 0.3s;
        }
        .contact-info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .contact-info-box i {
            font-size: 2.5rem;
            color: #4caf50;
            margin-bottom: 15px;
        }
        .contact-info-box h6 {
            color: #1a2e1a;
            font-weight: 600;
        }
        .contact-info-box p {
            color: #888;
            margin-bottom: 0;
        }
        .contact-form {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #e8f0e8;
        }
        .contact-form label {
            font-weight: 600;
            color: #1a2e1a;
        }
        .contact-form .form-control {
            border-radius: 8px;
            border: 2px solid #e8f0e8;
            padding: 10px 15px;
        }
        .contact-form .form-control:focus {
            border-color: #4caf50;
            box-shadow: none;
        }
        .btn-send {
            background: #4caf50;
            color: #fff;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-send:hover {
            background: #388e3c;
        }
        .footer {
            background: #1a2e1a;
            color: #d4d4d4;
            padding: 40px 0 20px;
            margin-top: 40px;
        }
        .footer h5 {
            color: #fff;
            font-weight: 600;
        }
        .footer a {
            color: #aaa;
            text-decoration: none;
            transition: 0.3s;
        }
        .footer a:hover {
            color: #4caf50;
        }
        /* Reset body padding for fixed navbar */
body {
    padding-top: 80px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
}

/* Fixed Navbar - Glass Morphism Effect */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: #1a2e1a !important;
    padding: 15px 0;
    transition: all 0.3s ease;
    box-shadow: 0 2px 20px rgba(0,0,0,0.3);
}

/* Navbar scroll effect - glass morphism */
.navbar-scrolled {
    background: rgba(26, 46, 26, 0.88) !important;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 4px 30px rgba(0,0,0,0.5);
    padding: 8px 0;
}

/* Navbar brand */
.navbar-brand {
    color: #fff !important;
    font-weight: bold;
    font-size: 1.5rem;
    transition: 0.3s;
}
.navbar-brand i {
    color: #4caf50;
}

/* Navbar links */
.navbar .nav-link {
    color: #d4d4d4 !important;
    font-weight: 500;
    transition: 0.3s;
    position: relative;
}
.navbar .nav-link:hover {
    color: #4caf50 !important;
}
.navbar .nav-link.active {
    color: #4caf50 !important;
}
.navbar .nav-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: #4caf50;
    transition: 0.3s;
}
.navbar .nav-link:hover::after,
.navbar .nav-link.active::after {
    width: 100%;
}

/* Search box */
.search-box {
    background: #2a402a;
    border-radius: 30px;
    padding: 5px 15px;
    border: none;
    color: #fff;
    transition: 0.3s;
}
.search-box::placeholder {
    color: #aaa;
}
.search-box:focus {
    outline: none;
    background: #2a402a;
    box-shadow: 0 0 0 2px #4caf50;
}

/* Icon buttons */
.icon-btn {
    color: #d4d4d4;
    font-size: 1.2rem;
    margin: 0 8px;
    transition: 0.3s;
    background: none;
    border: none;
}
.icon-btn:hover {
    color: #4caf50;
    transform: scale(1.1);
}

/* Navbar toggler for mobile */
.navbar-toggler {
    border-color: #4caf50;
}
.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(76, 175, 80, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/"><i class="fas fa-store"></i> ShopEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?= (current_url() == base_url('/') || current_url() == base_url()) ? 'active' : '' ?>" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= strpos(current_url(), 'products') !== false ? 'active' : '' ?>" href="/products">Products</a></li>
                <li class="nav-item"><a class="nav-link <?= strpos(current_url(), 'contact') !== false ? 'active' : '' ?>" href="/contact">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <input class="search-box me-2" type="search" placeholder="Search for products...">
               <button class="icon-btn" onclick="toggleWishlist(this)"><i class="far fa-heart"></i></button>
                <a href="/cart" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="fas fa-shopping-cart"></i></a>
                <a href="/login" class="icon-btn" style="color:#d4d4d4;text-decoration:none;"><i class="far fa-user"></i></a>
            </div>
        </div>
    </div>
</nav>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-envelope me-2"></i>Contact Us</h2>
                <nav class="breadcrumb">
                    <a href="/">Home</a>
                    <span class="mx-2 text-white-50">/</span>
                    <span class="active">Contact</span>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-4">
    <div class="container">
        <!-- Contact Info -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="contact-info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <h6>Visit Us</h6>
                    <p>123 Main Street, New York, NY 10001</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="contact-info-box">
                    <i class="fas fa-phone-alt"></i>
                    <h6>Call Us</h6>
                    <p>+1 (555) 123-4567</p>
                    <p class="small text-muted">Mon-Fri 9am-6pm</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="contact-info-box">
                    <i class="fas fa-envelope"></i>
                    <h6>Email Us</h6>
                    <p>support@shopease.com</p>
                    <p class="small text-muted">We reply within 24 hours</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="contact-form">
                    <h5 class="fw-bold mb-3">Send Us a Message</h5>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Order inquiry, support, etc." required>
                        </div>
                        <div class="mb-3">
                            <label>Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" rows="5" placeholder="Your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn-send"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5><i class="fas fa-store text-success"></i> ShopEase</h5>
                <p class="text-muted">Your one-stop shop for everything you need. Quality products, unbeatable prices.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Shipping Info</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Newsletter</h5>
                <p class="text-muted">Get the latest deals & updates</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Your email" style="background:#2a402a;border:none;color:#fff;">
                    <button class="btn btn-success" style="background:#4caf50;border:none;">Subscribe</button>
                </div>
            </div>
        </div>
        <hr class="border-top">
        <p class="text-center text-muted small">&copy; 2026 ShopEase. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Navbar scroll effect - Glass Morphism
    window.addEventListener('scroll', function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });
</script>
<script>
    // Wishlist toggle function
    function toggleWishlist(button) {
        var icon = button.querySelector('i');
        
        // Toggle between far (empty) and fas (filled)
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#dc3545';
            button.classList.add('wishlist-active');
            
            // Show a quick notification
            showNotification('Added to wishlist! ❤️');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '';
            button.classList.remove('wishlist-active');
            
            showNotification('Removed from wishlist! 💔');
        }
    }
    
    // Notification function
    function showNotification(message) {
        // Check if notification already exists
        var existing = document.querySelector('.wishlist-notification');
        if (existing) {
            existing.remove();
        }
        
        var notification = document.createElement('div');
        notification.className = 'wishlist-notification';
        notification.innerHTML = message;
        notification.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1a2e1a;
            color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            z-index: 9999;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
            font-size: 1rem;
            font-weight: 500;
            animation: slideIn 0.3s ease;
            border-left: 4px solid #4caf50;
        `;
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Add CSS animations for notification
    var style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100px); opacity: 0; }
        }
        .wishlist-active i {
            color: #dc3545 !important;
        }
    `;
    document.head.appendChild(style);
</script>
</body>
</html>