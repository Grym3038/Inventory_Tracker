<?php
/**
 * Title: Home Controller
 * Purpose: To view home page and handle authentication actions securely
 */

use Google\Service\IDS\IdsEmpty;
use Models\User;

// Centralize session start and security checks
if (session_status() !== PHP_SESSION_ACTIVE) {
    // Set secure session cookie params in front controller ideally
    session_start();
}

// Fingerprint validation to prevent session hijacking
define('FINGERPRINT_AGENT', hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? ''));
define('FINGERPRINT_IP', $_SERVER['REMOTE_ADDR'] ?? '');
if (isset($_SESSION['user_id'])) {
    if (($_SESSION['fingerprint_agent'] ?? '') !== FINGERPRINT_AGENT ||
        ($_SESSION['fingerprint_ip'] ?? '') !== FINGERPRINT_IP) {
        // Invalidate session
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?action=loginForm');
        exit();
    }
}

switch ($action)
{
        case 'error':
                $title = '404';
                $body = 'That page does not exist.';
                include('Views/error.php');
                exit();

        /**
         * List all albums
         */
        case 'home':
                include('Views/home.php');
                exit();
        
        
        case 'about':
                include('Views/About.php');
                exit();
        case 'loginForm':
                if (isset($_SESSION['user_id'])){
                include('Views/dashboard.php');
                exit();
                }
                include('Views/login.php');
                exit();
        case 'login':
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);


               
              
                // Sanitize inputs
                $email    = filter_input(INPUT_POST, 'loginEmail', FILTER_SANITIZE_EMAIL);
                $password = filter_input(INPUT_POST, 'loginPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
                $remember = filter_input(INPUT_POST, 'remember-me', FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);

                if ($remember) {
                        // 30 days
                        $lifetime = 60 * 60 * 24 * 30;
                } else {
                        // default (e.g. browser session)
                        $lifetime = 0;
                }

                $errors = [];
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Invalid email address.';
                }
                if (strlen($password) < 6) {
                        $errors[] = 'Password must be at least 6 characters.';
                }

                if ($errors) {
                        $_SESSION['errors'] = $errors;
                        include('Views/error.php');
                        exit;
                }

                // Authenticate
                $user = User::findByEmail($email);
                if (!$user || !password_verify($password, $user->password_hash)) {
                        $_SESSION['errors'] = ['Email or password incorrect.'];
                        include('Views/login.php');
                        exit;
                }

                // Success, bind session to fingerprint
                $_SESSION['user_id']            = $user->id;
                $_SESSION['fingerprint_agent']  = FINGERPRINT_AGENT;
                $_SESSION['fingerprint_ip']     = FINGERPRINT_IP;
                $_SESSION['name']               = $user->name;
                $_SESSION['role']               = $user->role;

                // Extend cookie for "remember me"
                if ($remember) {
                $params = session_get_cookie_params();
                setcookie(
                        session_name(),
                        session_id(),
                        time() + 60 * 60 * 24 * 30,
                        $params['path'],
                        $params['domain'] ?? '',
                        $params['secure'],
                        $params['httponly']
                );
                }  
                include('Views/dashboard.php');
                exit();
        case 'signup':


                // Sanitize inputs
                $name            = trim($_POST['signupName'] ?? '');
                $email           = filter_input(INPUT_POST, 'signupEmail', FILTER_SANITIZE_EMAIL);
                $password        = $_POST['signupPassword'] ?? '';
                $confirmPassword = $_POST['confirmPassword'] ?? '';
                $termsAccepted   = isset($_POST['terms']);

                $errors = [];
                if (strlen($name) < 2) {
                $errors[] = 'Name must be at least 2 characters.';
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email address.';
                }
                if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
                }
                if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match.';
                }
                if (!$termsAccepted) {
                $errors[] = 'Terms must be accepted.';
                }

                if ($errors) {
                $_SESSION['errors'] = $errors;
                $title= 'error';
                $body = ' ';
                foreach($errors as $error){
                        $body = $body . $error;
                }
                include('Views/error.php');
                exit;
                }

                // Create user
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User();

                $user->name          = $name;
                $user->email         = $email;
                $user->password_hash = $hash;
                $user->role = 'employee';
                // Set client_id to a valid existing client, e.g. from session or default
                $user->client_id     = $_SESSION['client_id'] ?? 1;
                $user->save();

                // Success
                $_SESSION["name"] = $user->name;
                $_SESSION['user_id'] = $user->id;
                $_SESSION['role'] = 'employee';
                include('Views/dashboard.php');
                exit();
        case 'logout':
   
                // Clear session data
                $_SESSION = [];
                // Invalidate session cookie
                if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(
                        session_name(),
                        '',
                        time() - 42000,
                        $params['path'],
                        $params['domain'] ?? '',
                        $params['secure'],
                        $params['httponly']
                );
                }
                session_destroy();

                // Redirect to home
                header('Location: index.php?action=home');
                exit;
        
        case 'redirect':
                include('Views/redirect.php');
                exit();

}
