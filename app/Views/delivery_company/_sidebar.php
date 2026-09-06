<!-- app/Views/delivery_company/_sidebar.php -->
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

        <!-- MAIN -->
        <div class="sidebar-category">Main</div>
        <ul class="sidebar-menu">
            <li class="<?= $active_menu == 'dashboard' ? 'active' : '' ?>" onclick="location.href='/delivery/dashboard'" data-tooltip="Dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span class="menu-text">Dashboard</span>
            </li>
            <li class="<?= $active_menu == 'orders' ? 'active' : '' ?>" onclick="location.href='/delivery/orders'" data-tooltip="Delivery Orders">
                <i class="fas fa-list"></i>
                <span class="menu-text">Delivery Orders</span>
            </li>
            <li class="<?= $active_menu == 'assign' ? 'active' : '' ?>" onclick="location.href='/delivery/assign'" data-tooltip="Assign Delivery">
                <i class="fas fa-user-plus"></i>
                <span class="menu-text">Assign Delivery</span>
            </li>
            <li class="<?= $active_menu == 'active' ? 'active' : '' ?>" onclick="location.href='/delivery/active'" data-tooltip="Active Deliveries">
                <i class="fas fa-spinner"></i>
                <span class="menu-text">Active Deliveries</span>
            </li>
            <li class="<?= $active_menu == 'completed' ? 'active' : '' ?>" onclick="location.href='/delivery/completed'" data-tooltip="Completed Deliveries">
                <i class="fas fa-check-circle"></i>
                <span class="menu-text">Completed Deliveries</span>
            </li>
        </ul>

        <!-- MANAGEMENT -->
        <div class="sidebar-category">Management</div>
        <ul class="sidebar-menu">
            <li class="<?= $active_menu == 'agents' ? 'active' : '' ?>" onclick="location.href='/delivery/agents'" data-tooltip="Delivery Agents">
                <i class="fas fa-users"></i>
                <span class="menu-text">Delivery Agents</span>
            </li>
            <li class="<?= $active_menu == 'history' ? 'active' : '' ?>" onclick="location.href='/delivery/history'" data-tooltip="Delivery History">
                <i class="fas fa-history"></i>
                <span class="menu-text">Delivery History</span>
            </li>
        </ul>

        <!-- ACCOUNT -->
        <div class="sidebar-category">Account</div>
        <ul class="sidebar-menu">
            <li class="<?= $active_menu == 'change-password' ? 'active' : '' ?>" onclick="location.href='/delivery/change-password'" data-tooltip="Change Password">
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