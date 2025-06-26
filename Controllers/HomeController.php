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
                include('Views/IndexView.php');
                exit();
        case 'users':
                include('Views/users.php');
                exit();
        case 'about':
                include('Views/About.php');
                exit();
        case 'log_in':
                include('Views/login.php');
                exit();
        case 'items':
                include('Views/items.php');
                exit();
}
