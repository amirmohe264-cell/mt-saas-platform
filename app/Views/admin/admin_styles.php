<!-- app/Views/admin/admin_styles.php -->
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

    .navbar {
        background: #1a2e1a !important;
        padding: 15px 0;
        box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 1050;
    }
    .navbar-brand { color: #fff !important; font-weight: bold; font-size: 1.5rem; }
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

    .sidebar-wrapper {
        position: fixed;
        top: 80px; left: 0;
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
    .sidebar-wrapper.collapsed .admin-name,
    .sidebar-wrapper.collapsed .admin-role,
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
    .sidebar-wrapper.collapsed .admin-avatar { width: 45px; height: 45px; font-size: 1.2rem; }

    body.sidebar-collapsed { padding-left: 70px; }

    .sidebar-card .admin-avatar {
        width: 70px; height: 70px; border-radius: 50%;
        background: #4caf50; color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 10px;
        transition: all 0.3s ease;
    }
    .sidebar-card .admin-name {
        text-align: center; font-weight: 700; color: #1a2e1a; font-size: 1rem;
    }
    .sidebar-card .admin-role {
        text-align: center; font-size: 0.8rem;
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

    .main-content {
        padding: 20px 30px;
        min-height: calc(100vh - 160px);
    }

    .page-header {
        background: #f8f9fa;
        color: #1a2e1a;
        padding: 20px 0 20px;
        border-bottom: 1px solid #e8f0e8;
    }
    .page-header h2 { font-weight: 700; color: #1a2e1a; }
    .page-header .breadcrumb { background: none; padding: 0; margin: 0; }
    .page-header .breadcrumb a { color: #4caf50; text-decoration: none; }
    .page-header .breadcrumb .active { color: #888; }

    /* ========================================== */
    /* FEE CARD STYLES */
    /* ========================================== */
    .fee-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e8f0e8;
        margin-bottom: 20px;
    }
    .fee-card .fee-icon {
        font-size: 2rem;
        color: #4caf50;
        margin-bottom: 10px;
    }

    /* ========================================== */
    /* COMMISSION CARD STYLES */
    /* ========================================== */
    .commission-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e8f0e8;
        margin-bottom: 20px;
    }

    /* ========================================== */
    /* STAT CARD STYLES */
    /* ========================================== */
    .stat-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e8f0e8;
        text-align: center;
    }
    .stat-card .number {
        font-size: 2rem;
        font-weight: 700;
        color: #1a2e1a;
    }
    .stat-card .label {
        color: #888;
        font-size: 0.85rem;
    }

    /* ========================================== */
    /* TABLE CARD STYLES */
    /* ========================================== */
    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e8f0e8;
    }

    /* ========================================== */
    /* FORM STYLES */
    /* ========================================== */
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 2px solid #e8f0e8;
    }
    .form-control:focus {
        border-color: #4caf50;
        box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
    }
    .form-select {
        border-radius: 10px;
        padding: 12px 15px;
        border: 2px solid #e8f0e8;
    }
    .form-select:focus {
        border-color: #4caf50;
        box-shadow: 0 0 0 0.2rem rgba(76,175,80,0.25);
    }

    /* ========================================== */
    /* BUTTON STYLES */
    /* ========================================== */
    .btn-success {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
    }
    .btn-sm-custom {
        padding: 4px 10px;
        font-size: 0.8rem;
        border-radius: 6px;
    }

    /* ========================================== */
    /* STATUS BADGE STYLES */
    /* ========================================== */
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .status-active { background: #d4edda; color: #155724; }
    .status-inactive { background: #f8d7da; color: #721c24; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-approved { background: #d4edda; color: #155724; }
    .status-rejected { background: #f8d7da; color: #721c24; }
    .status-processing { background: #cce5ff; color: #004085; }
    .status-paid { background: #d4edda; color: #155724; }
    .status-failed { background: #f8d7da; color: #721c24; }

    /* ========================================== */
    /* VERIFICATION CODE STYLES */
    /* ========================================== */
    .verification-code {
        background: #f0f8f0;
        padding: 4px 10px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 0.85rem;
        font-weight: 600;
        color: #4caf50;
        display: inline-block;
    }

    /* ========================================== */
    /* ASSIGNMENT ITEM STYLES */
    /* ========================================== */
    .assignment-item {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        border: 1px solid #e8f0e8;
        margin-bottom: 12px;
    }

    /* ========================================== */
    /* REFUND ITEM STYLES */
    /* ========================================== */
    .refund-item {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        border: 1px solid #e8f0e8;
        margin-bottom: 12px;
    }

    /* ========================================== */
    /* DETAIL CARD STYLES */
    /* ========================================== */
    .detail-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e8f0e8;
        margin-bottom: 20px;
    }
    .detail-card .label {
        color: #888;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-card .value {
        font-weight: 600;
        color: #1a2e1a;
        font-size: 1rem;
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
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
        .sidebar-wrapper.collapsed .admin-name,
        .sidebar-wrapper.collapsed .admin-role,
        .sidebar-wrapper.collapsed .sidebar-category { display: block; }
        body.sidebar-collapsed { padding-left: 0; }
        .main-content { padding: 15px; }
        .fee-card { padding: 15px; }
        .commission-card { padding: 15px; }
        .stat-card { padding: 15px; }
        .table-card { padding: 15px; }
    }
</style>