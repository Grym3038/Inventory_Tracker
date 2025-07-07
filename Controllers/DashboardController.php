<?php
/**
 * Title: Home Controller
 * Purpose: To view home page and any other actions
 */

use Google\Service\IDS\IdsEmpty;
use Models\User;


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
                    include('Views/users.php');
                exit();
                }
                
    case 'dashboard':
                
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role === 'employee') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                include('Views/dashboard.php');
                exit();
    case 'items':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role === 'employee') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                include('Views/items.php');
                exit();

}