<?php
/**
 * Title: Header Partial
 * Purpose: To provide a header for all pages of the application and include
 *          navigation links
 */
?>
<!DOCTYPE html>
<html lang="en-us" class=" ">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shelf-aware</title>

        <link rel="stylesheet" href="src\output.css?v=2" />

    <link rel="stylesheet" href="Lib\CSS\styles.css?v=2">
    <link href="Lib\Images\Logo_Mower_Black.svg" rel="icon" media="(prefers-color-scheme: light)">
    <link href="Lib\Images\Logo_Mower_White.svg" rel="icon" media="(prefers-color-scheme: dark)">


</head>

<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Adiman</h2>
            </div>
            <div class="sidebar-menu">
                <div class="menu-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <a href="?action=home" class="">Analytics</a>
                </div>
                <div class="menu-item">
                    <i class="fas fa-users"></i>
                    <a href="?action=users" class="">User Management</a>
                </div>
                <div class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <a href="?action=items" class="">Content</a>
                </div>
                <div class="menu-item">
                    <i class="fas fa-cog"></i>
                    <a href="?action=log_in" class="">Settings</a>
                </div>
                <div class="menu-item">
                    <i class="fas fa-question-circle"></i>
                    <a href="?action=about" class="">Help</a>
                </div>
            </div>
        </div>
    