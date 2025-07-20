<?php
/**
 * Title: Sidebar Partial
 * Purpose: To provide a sidebar for all pages of the application and include
 *          navigation links
 */

// Ensure user variable is available
if (!isset($user) && isset($_SESSION['user_id'])) {
    $user = User::findById($_SESSION['user_id']);
}

// Check if dark mode is enabled
$is_dark_mode = $_SESSION['dark_mode'] ?? false;
?>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
        <h2><?= $_SESSION["name"] ?? 'User' ?></h2>
            </div>
            <div class="sidebar-menu">
        <div class="menu-item <?php echo ($action === 'dashboard' || $action === 'adminDashboard' || $action === 'ownerDashboard' || $action === 'employeeDashboard') ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
            <a href="?action=dashboard">Dashboard</a>
                </div>
        <?php if (isset($user) && $user->role === 'owner'): ?>

        <div class="menu-item <?= $action === 'items' ? 'active' : '' ?>">
                    <i class="fas fa-file-alt"></i>
            <a href="?action=items">Products</a>
                </div>
        <?php elseif (isset($user) && $user->role === 'admin'): ?>
                <div class="menu-item <?= $action === 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i>
            <a href="?action=users">User Management</a>
                </div>
        <?php endif; ?>
                <div class="menu-item <?= $action === 'settings' ? 'active' : '' ?>">
                    <i class="fas fa-cog"></i>
            <a href="?action=settings">Settings</a>
                </div>

            </div>
    <div class="sidebar-footer">
                
        <a href="?action=logout" class="text-red-700 hover:text-red-950 font-bold">Logout</a>
            </div>
        </div>
    