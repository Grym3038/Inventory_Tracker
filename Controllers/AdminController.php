<?php
/**
 * Title: Dashboard Controller
 * Purpose: To view Dashboard page and any other actions
 */

use Google\Service\IDS\IdsEmpty;
use Models\User;
use Models\AdminDBAccess;

switch ($action)
{
    case 'users':
               
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role != 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }else{
                    $clients = AdminDBAccess::getAllClients();
                    // 3) Read filters & pagination from GET
                    $clientId    = filter_input(INPUT_GET,  'client_id', FILTER_VALIDATE_INT) ?? 0;
                    $emailFilter = trim($_GET['email'] ?? '');
                    $page        = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
                    $perPage     = 10;
                    $offset      = ($page - 1) * $perPage;

                    $totalUsers = 0;
                    $users      = [];

                    if ($clientId) {
                        // 4) Count & fetch only if a client is selected
                        $totalUsers = AdminDBAccess::countUsers($clientId, $emailFilter);
                        $users      = AdminDBAccess::getUsers(
                            $clientId, $perPage, $offset, $emailFilter
                        );
                    }

                    include('Views/Admin/users.php');
                    exit();
                
                }
    case 'editUser':
                 // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role != 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }else{
                    // fetch & validate the user ID
                    $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                    if (!$userId) {
                        $_SESSION['errors'] = ['Invalid user ID'];
                        header('Location: index.php?action=users');
                        exit();
                    }

                    // load the user record
                    $user = User::findById($userId);
                    if (!$user) {
                        $_SESSION['errors'] = ['User not found'];
                        header('Location: index.php?action=users');
                        exit();
                    }

                    // load clients for dropdown
                    $clients = AdminDBAccess::getAllClients();

                    include('Views/Admin/editUser.php');
                    exit();
                
                }
    case 'updateUser':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role != 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }else{
                    // 2) Sanitize & validate POSTed data
                    $userId   = filter_input(INPUT_POST, 'user_id',   FILTER_VALIDATE_INT);
                    $newRole  = filter_input(INPUT_POST, 'role',      FILTER_SANITIZE_STRING);
                    $clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);

                    // 3) Only proceed if we have valid inputs
                    if ($userId && in_array($newRole, ['admin','owner','manager','employee'], true) && $clientId) {
                        // Delegate to your DB helper
                        AdminDBAccess::updateUser($userId, $newRole, $clientId);
                    }

                    // 4) Redirect back to the users list
                    header('Location: index.php?action=users');
                    exit();
                }
    case 'adminDashboard':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role !== 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                include('Views/Dashboard/adminDashboard.php');
                exit();
    case 'add_user':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role != 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                
                // Load clients for dropdown
                $clients = AdminDBAccess::getAllClients();
                
                include('Views/Admin/addUser.php');
                exit();
    case 'edit_user':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role != 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                
                // fetch & validate the user ID
                $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if (!$userId) {
                    $_SESSION['errors'] = ['Invalid user ID'];
                    header('Location: index.php?action=users');
                    exit();
                }

                // load the user record
                $user = User::findById($userId);
                if (!$user) {
                    $_SESSION['errors'] = ['User not found'];
                    header('Location: index.php?action=users');
                    exit();
                }

                // load clients for dropdown
                $clients = AdminDBAccess::getAllClients();

                include('Views/Admin/editUser.php');
                exit();
    case 'create_user':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role != 'admin') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Sanitize and validate inputs
                    $name = trim($_POST['name'] ?? '');
                    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $password = $_POST['password'] ?? '';
                    $confirm_password = $_POST['confirm_password'] ?? '';
                    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
                    $client_id = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
                    
                    $errors = [];
                    
                    if (strlen($name) < 2) {
                        $errors[] = 'Name must be at least 2 characters long.';
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Please enter a valid email address.';
                    }
                    if (strlen($password) < 6) {
                        $errors[] = 'Password must be at least 6 characters long.';
                    }
                    if ($password !== $confirm_password) {
                        $errors[] = 'Passwords do not match.';
                    }
                    if (!in_array($role, ['admin', 'owner', 'employee'])) {
                        $errors[] = 'Please select a valid role.';
                    }
                    if (!$client_id) {
                        $errors[] = 'Please select a client.';
                    }
                    
                    // Check if email already exists
                    if (User::findByEmail($email)) {
                        $errors[] = 'Email address already exists.';
                    }
                    
                    if (empty($errors)) {
                        // Create new user
                        $new_user = new User();
                        $new_user->name = $name;
                        $new_user->email = $email;
                        $new_user->password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $new_user->role = $role;
                        $new_user->client_id = $client_id;
                        $new_user->darkmode_on = false; // Default to light mode
                        
                        if ($new_user->save()) {
                            $_SESSION['success'] = ['User created successfully.'];
                            header('Location: index.php?action=users');
                            exit;
                        } else {
                            $errors[] = 'Failed to create user. Please try again.';
                        }
                    }
                    
                    if (!empty($errors)) {
                        $_SESSION['errors'] = $errors;
                        // Load clients for dropdown
                        $clients = AdminDBAccess::getAllClients();
                        include('Views/Admin/addUser.php');
                        exit;
                    }
                }
                
                // If not POST, redirect to add user form
                header('Location: index.php?action=add_user');
                exit;
}