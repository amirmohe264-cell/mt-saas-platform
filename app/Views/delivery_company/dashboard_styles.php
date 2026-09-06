<!-- app/Views/delivery_company/dashboard_styles.php -->
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
    }

    /* Navbar */
    .navbar {
        background: #1a2e1a !important;
        padding: 12px 0;
        box-shadow: 0 2px 20px rgba(0,0,0,0.3);
    }
    .navbar-brand {
        color: #fff !important;
        font-weight: bold;
        font-size: 1.3rem;
    }
    .navbar-brand i { color: #4caf50; }
    .navbar .nav-link { color: #d4d4d4 !important; font-weight: 500; transition: 0.3s; }
    .navbar .nav-link:hover { color: #4caf50 !important; }
    .icon-btn {
        color: #d4d4d4;
        font-size: 1.2rem;
        margin: 0 5px;
        transition: 0.3s;
        background: none;
        border: none;
    }
    .icon-btn:hover { color: #4caf50; transform: scale(1.1); }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 70px;
        left: 0;
        width: 250px;
        height: calc(100vh - 70px);
        background: #fff;
        border-right: 1px solid #e8f0e8;
        padding: 20px 0;
        overflow-y: auto;
        z-index: 1000;
    }
    .sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar::-webkit-scrollbar-thumb { background: #4caf50; border-radius: 4px; }
    .sidebar .company-info {
        text-align: center;
        padding: 0 15px 20px;
        border-bottom: 1px solid #e8f0e8;
    }
    .sidebar .company-info .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #4caf50;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin: 0 auto 10px;
    }
    .sidebar .company-info .name {
        font-weight: 700;
        color: #1a2e1a;
    }
    .sidebar .company-info .email {
        font-size: 0.8rem;
        color: #888;
    }
    .sidebar .menu-item {
        padding: 12px 20px;
        display: flex;
        align-items: center;
        color: #555;
        text-decoration: none;
        transition: 0.3s;
        border-left: 3px solid transparent;
        cursor: pointer;
    }
    .sidebar .menu-item:hover {
        background: #f0f8f0;
        color: #4caf50;
        border-left-color: #4caf50;
    }
    .sidebar .menu-item.active {
        background: #f0f8f0;
        color: #4caf50;
        border-left-color: #4caf50;
        font-weight: 600;
    }
    .sidebar .menu-item i {
        width: 25px;
        margin-right: 12px;
        font-size: 1rem;
    }
    .sidebar .menu-category {
        font-size: 0.65rem;
        font-weight: 700;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 15px 20px 5px;
        border-top: 1px solid #f0f0f0;
        margin-top: 5px;
    }
    .sidebar .menu-category:first-child { border-top: none; margin-top: 0; }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        padding: 20px 30px;
        margin-top: 70px;
        min-height: calc(100vh - 70px);
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-assigned { background: #cce5ff; color: #004085; }
    .status-picked_up { background: #d1ecf1; color: #0c5460; }
    .status-in_transit { background: #d4edda; color: #155724; }
    .status-delivered { background: #d4edda; color: #155724; }
    .status-completed { background: #c3e6cb; color: #155724; }
    .status-failed { background: #f8d7da; color: #721c24; }

    .order-item {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        border: 1px solid #e8f0e8;
        margin-bottom: 12px;
        transition: 0.3s;
    }
    .order-item:hover { border-color: #4caf50; }
    .order-item .order-number { font-weight: 600; color: #1a2e1a; }
    .order-item .order-date { color: #888; font-size: 0.85rem; }

    .btn-sm-custom {
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    @media (max-width: 992px) {
        .sidebar {
            position: relative;
            top: 0;
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 1px solid #e8f0e8;
        }
        .main-content {
            margin-left: 0;
            margin-top: 0;
            padding: 15px;
        }
    }
</style>