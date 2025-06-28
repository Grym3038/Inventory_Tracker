<?php
/**
 * Title: Home Controller
 * Purpose: To view home page and any other actions
 */

switch ($action)
{
        /**
         * List all albums
         */
        case 'home':
                include('Views/home.php');
                exit();
        case 'dashboard':
                include('Views/dashboard.php');
                exit();
        case 'users':
                include('Views/users.php');
                exit();
        case 'about':
                include('Views/About.php');
                exit();
        case 'login':
                include('Views/login.php');
                exit();
        case 'items':
                include('Views/items.php');
                exit();
        case 'redirect':
                include('Views/redirect.php');
                exit();

}
