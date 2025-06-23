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
    <title>Mike's Mowing</title>

        <link rel="stylesheet" href="src\output.css" />

    <link rel="stylesheet" href="Lib\CSS\styles.css?v=1">
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
                    <a href="Views\About.php" class="">Analytics</a>
                </div>
                <div class="menu-item">
                    <i class="fas fa-users"></i>
                    <a href="?action=about" class="">User Management</a>
                </div>
                <div class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Content</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </div>
                <div class="menu-item">
                    <i class="fas fa-question-circle"></i>
                    <span>Help</span>
                </div>
            </div>
        </div>
    