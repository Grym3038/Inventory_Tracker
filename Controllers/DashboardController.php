<?php
/**
 * Title: Dashboard Controller
 * Purpose: To view Dashboard page and any other actions
 */

use Google\Service\IDS\IdsEmpty;
use Models\User;


switch ($action)
{
    case 'dashboard':
                    if($_SESSION['role'] === 'employee'){
                        header('Location: index.php?action=employeeDashboard');
                        exit();
                    }
                    elseif( $_SESSION['role'] === 'owner'){
                        header('Location: index.php?action=ownerDashboard');
                        exit();
                    }
                    elseif( $_SESSION['role'] === 'admin'){
                        header('Location: index.php?action=adminDashboard');
                        exit();
                    } else { $_SESSION['errors'] = ['An error occured. Please try again'];
                        header('Location: index.php?action=error');
                        exit();
                    }
        
    case 'ownerDashboard':
                
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if ($user->role !== 'owner') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
                include('Views/ownerDashboard.php');
                exit();
    case 'employeeDashboard':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
    
                include('Views/employeeDashboard.php');
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