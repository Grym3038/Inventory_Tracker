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
                include('Views/Dashboard/ownerDashboard.php');
                exit();
    case 'employeeDashboard':
                // Redirect to login if not authenticated
                if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
    
                include('Views/Dashboard/employeeDashboard.php');
                exit();
                case 'settings':
                    // Redirect to login if not authenticated
                    if (empty($_SESSION['user_id'])) {
                        header('Location: index.php?controller=home&action=login');
                        exit;
                    }
                    
                    // Get user information from database
                    $user = User::findById($_SESSION['user_id']);
                    if (!$user) {
                        $_SESSION['errors'] = ['User not found.'];
                        header('Location: index.php?action=error');
                        exit;
                    }

                    $user_name = $user->name;
                    $user_email = $user->email;
                    $user_role = $user->role;

                    // Handle dark mode toggle
                    if (isset($_POST['dark_mode_value'])) {
                        $new_dark_mode = ($_POST['dark_mode_value'] === '1');
                        if ($user->updateDarkMode($new_dark_mode)) {
                            $_SESSION['dark_mode'] = $new_dark_mode;
                            header('Location: ?action=settings');
                            exit;
                        } else {
                            $_SESSION['errors'] = ['Failed to update dark mode preference.'];
                        }
                    }

                    // Handle name update
                    if (isset($_POST['update_name']) && !empty($_POST['new_name'])) {
                        $new_name = trim($_POST['new_name']);
                        if (strlen($new_name) >= 2) {
                            if ($user->updateName($new_name)) {
                                $_SESSION['name'] = $new_name;
                                $user_name = $new_name;
                                $_SESSION['success'] = ['Name updated successfully.'];
                            } else {
                                $_SESSION['errors'] = ['Failed to update name.'];
                            }
                        } else {
                            $_SESSION['errors'] = ['Name must be at least 2 characters long.'];
                        }
                    }

                    $is_dark_mode = $user->darkmode_on;
                    
                    include('Views/Dashboard/settings.php');
                    exit();
    
            case 'paginated_table':
                    // Redirect to login if not authenticated
                    if (empty($_SESSION['user_id'])) {
                        header('Location: index.php?controller=home&action=login');
                        exit;
                    }
                    include('Views/Dashboard/paginated_table.php');
                    exit();
}