<?php
/**
 * Title: Dashboard Header Partial
 * Purpose: To provide the HTML head structure for dashboard pages only
 */

// Check if dark mode is enabled
$is_dark_mode = $_SESSION['dark_mode'] ?? false;
?>
<!DOCTYPE html>
<html lang="en-us" class="<?= $is_dark_mode ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shelf-aware</title>
    <link rel="stylesheet" href="src\output.css?v=2" />
    <link rel="stylesheet" href="Lib\CSS\styles.css?v=2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="Lib\Images\Logo_Mower_Black.svg" rel="icon" media="(prefers-color-scheme: light)">
    <link href="Lib\Images\Logo_Mower_White.svg" rel="icon" media="(prefers-color-scheme: dark)">
</head>
<body class="<?= $is_dark_mode ? 'dark-mode' : '' ?>">
    <div class="dashboard"> 