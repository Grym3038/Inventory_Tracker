<?php
/**
 * Title: Index Controller
 * Purpose: To serve as the entry point of the application that imports all
 *          models and controllers
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Import  models




// Define a 404 Not Found function
function return404()
{
    $title = '404';
    $body = 'That page does not exist.';
    include('Views/error.php');
    exit();
}
// Define a error 500 function

function return500()
{
    $title = '500';
    $body = 'ServerError';
    include('Views/error.php');
    exit();
}

// Start the session
$lifetime = 60 * 60 * 24 * 365; // 1 year in seconds
session_set_cookie_params($lifetime, '/');
session_start();


function filter_string_polyfill(string $string): string
{
    $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
    return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}

// Get the action
$action = filter_string_polyfill(isset($_GET['action']) ? (string)$_GET['action'] : 'home');


// Register the controllers
require('Controllers/HomeController.php');


// return404();
