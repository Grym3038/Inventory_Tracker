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
    case 'attribution':
            include('Views/attribution.php');
            exit();
    case 'about':
            include('Views/About.php');
            exit();
    }
