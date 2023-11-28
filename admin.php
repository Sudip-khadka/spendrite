<?php
// Simulated admin login
$adminLoggedIn = true;

if (!$adminLoggedIn) {
    // Redirect to the admin login page if the admin is not logged in
    header("Location: admin_login.php");
    exit();
}

// Simulated admin user data
$adminUser = [
    'id' => 1,
    'username' => 'admin',
    'role' => 'admin',
];

// Simulated user roles and permissions
$roles = [
    'admin' => ['User Management', 'Content Management', 'Site Settings'],
    'editor' => ['Content Management'],
];

// Check the admin's role and permissions
$adminRole = $adminUser['role'];

// Simulated admin panel actions
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    case 'dashboard':
        // Display admin dashboard
        include('admin_dashboard.php');
        break;

    case 'user_management':
        if (in_array('User Management', $roles[$adminRole])) {
            // Display user management page
            include('admin_user_management.php');
        } else {
            // Permission denied
            echo "Permission denied!";
        }
        break;

    case 'content_management':
        if (in_array('Content Management', $roles[$adminRole])) {
            // Display content management page
            include('admin_content_management.php');
        } else {
            // Permission denied
            echo "Permission denied!";
        }
        break;

    case 'site_settings':
        if (in_array('Site Settings', $roles[$adminRole])) {
            // Display site settings page
            include('admin_site_settings.php');
        } else {
            // Permission denied
            echo "Permission denied!";
        }
        break;

    default:
        // Handle invalid actions
        echo "Invalid action!";
}

// Simulated admin panel navigation
?>
<nav>
    <ul>
        <li><a href="admin.php?action=dashboard">Dashboard</a></li>
        <?php if (in_array('User Management', $roles[$adminRole])) : ?>
            <li><a href="admin.php?action=user_management">User Management</a></li>
        <?php endif; ?>
        <?php if (in_array('Content Management', $roles[$adminRole])) : ?>
            <li><a href="admin.php?action=content_management">Content Management</a></li>
        <?php endif; ?>
        <?php if (in_array('Site Settings', $roles[$adminRole])) : ?>
            <li><a href="admin.php?action=site_settings">Site Settings</a></li>
        <?php endif; ?>
    </ul>
</nav>
