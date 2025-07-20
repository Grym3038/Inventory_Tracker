<?php
namespace Controllers;

use Models\Item;
use Models\User;

switch ($action)
{
    // List all items for a client
    case 'items':
    
        // Clear any old session errors that might be persisting
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
        
        if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if (!$user) {
                    // User not found in database
                    $_SESSION['errors'] = ['User session invalid. Please login again.'];
                    header('Location: index.php?action=loginForm');
                    exit;
                }
                if ($user->role === 'employee') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
        $client_id = $_SESSION['client_id'] ?? $user->client_id ?? 1; // Use user's client_id if session doesn't have it
        
        // Pagination and filter parameters
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        $per_page = 10; // Items per page
        $stock_filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        // Validate filter parameter
        $valid_filters = ['low-stock', 'in-stock', 'out-of-stock'];
        if ($stock_filter && !in_array($stock_filter, $valid_filters)) {
            $stock_filter = null;
        }
        
        // Get total items with filter
        $total_items = Item::countByClientWithFilter($client_id, $stock_filter);
        $total_pages = ceil($total_items / $per_page);
        
        // Ensure page is within valid range
        if ($page < 1) $page = 1;
        if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
        
        // Get items with filter
        $items = Item::findAllByClientPaginatedWithFilter($client_id, $page, $per_page, $stock_filter);
        
        // Pagination data for view
        $pagination = [
            'current_page' => $page,
            'total_pages' => $total_pages,
            'total_items' => $total_items,
            'per_page' => $per_page,
            'has_previous' => $page > 1,
            'has_next' => $page < $total_pages,
            'previous_page' => $page - 1,
            'next_page' => $page + 1
        ];

        include __DIR__ . '/../Views/Item/itemsView.php';
        exit();

    // Show edit form and process update
    case 'edit_item':

        if (empty($_SESSION['user_id'])) {
                    header('Location: index.php?controller=home&action=login');
                    exit;
                }
                $user = User::findById($_SESSION['user_id']);
                if (!$user) {
                    // User not found in database
                    $_SESSION['errors'] = ['User session invalid. Please login again.'];
                    header('Location: index.php?action=loginForm');
                    exit;
                }
                if ($user->role === 'employee') {
                    // deny access
                    $_SESSION['errors'] = ['Access denied: insufficient permissions.'];
                    header('Location: index.php?action=error');
                    exit;
                }
    
        $client_id = $_SESSION['client_id'] ?? 1;
        $errors = [];
        $success = false;

        $item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$item_id) {
            $errors[] = "No item ID provided.";
            include __DIR__ . '/../Views/Item/editItem.php';
            return;
        }

        $item = Item::findById($item_id);
        if (!$item) {
            $errors[] = "Item not found.";
            include __DIR__ . '/../Views/Item/editItem.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate
            $sku = trim($_POST['sku'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $threshold_qty = filter_input(INPUT_POST, 'threshold_qty', FILTER_VALIDATE_INT);
            $current_qty = filter_input(INPUT_POST, 'current_qty', FILTER_VALIDATE_INT);

            if ($sku === '') $errors[] = "SKU is required.";
            if ($name === '') $errors[] = "Name is required.";
            if ($threshold_qty === false || $threshold_qty < 0) $errors[] = "Threshold must be a non-negative integer.";
            if ($current_qty === false || $current_qty < 0) $errors[] = "Quantity must be a non-negative integer.";
            if (Item::skuExists($sku, $client_id, $item_id)) $errors[] = "SKU already exists for this tenant.";

            if (empty($errors)) {
                $item->sku = $sku;
                $item->name = $name;
                $item->threshold_qty = $threshold_qty;
                $item->current_qty = $current_qty;
                if ($item->save()) {
                    $success = true;
                } else {
                    $errors[] = "Database update failed.";
                }
            }
        }

        include __DIR__ . '/../Views/Item/editItem.php';
        exit();

    // Show delete confirmation page
    case 'confirm_delete':
        
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

        $item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $current_page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        $stock_filter = filter_input(INPUT_GET, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (!$item_id || $type !== 'item') {
            header('Location: index.php?action=items');
            exit;
        }

        $item = Item::findById($item_id);
        if (!$item) {
            header('Location: index.php?action=items');
            exit;
        }

        // Set variables for the confirmation page
        $item_name = $item->name;
        $item_sku = $item->sku;
        $item_qty = $item->current_qty;
        $item_threshold = $item->threshold_qty;
        $delete_url = 'index.php?action=delete_item';
        $return_url = 'index.php?action=items&page=' . $current_page;
        if ($stock_filter) {
            $return_url .= '&filter=' . urlencode($stock_filter);
        }

        include __DIR__ . '/../Views/Item/deleteConfirm.php';
        exit();

    // Handle deleting an item (after confirmation)
    case 'delete_item':
    
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

        // Check if this is a confirmed deletion
        $confirmed = filter_input(INPUT_POST, 'confirmed', FILTER_VALIDATE_INT);
        $confirm_delete = filter_input(INPUT_POST, 'confirm_delete', FILTER_SANITIZE_STRING);
        $type_confirmation = filter_input(INPUT_POST, 'type_confirmation', FILTER_SANITIZE_STRING);
        $current_page = filter_input(INPUT_POST, 'current_page', FILTER_VALIDATE_INT) ?: 1;
        $stock_filter = filter_input(INPUT_POST, 'stock_filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (!$confirmed || !$confirm_delete || $type_confirmation !== 'DELETE') {
            header('Location: index.php?action=items');
            exit;
        }

        $item_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($item_id) {
            $item = Item::findById($item_id);
            if ($item) {
                if ($item->delete()) {
                    $_SESSION['success'] = 'Item deleted successfully.';
                } else {
                    $_SESSION['errors'] = ['Failed to delete item. This item may have related records that prevent deletion.'];
                }
            } else {
                $_SESSION['errors'] = ['Item not found.'];
            }
        } else {
            $_SESSION['errors'] = ['Invalid item ID provided.'];
        }
        
        $redirect_url = "index.php?action=items&page=" . $current_page;
        if ($stock_filter) {
            $redirect_url .= "&filter=" . urlencode($stock_filter);
        }
        header("Location: " . $redirect_url);
        exit();

    // Show add item form and process new item
    case 'add_item':

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
        
        $client_id = $_SESSION['client_id'] ?? 1;
        $errors = [];
        $success = false;
        $item = new Item();
        $item->client_id = $client_id;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sku = trim($_POST['sku'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $threshold_qty = filter_input(INPUT_POST, 'threshold_qty', FILTER_VALIDATE_INT);
            $current_qty = filter_input(INPUT_POST, 'current_qty', FILTER_VALIDATE_INT);

            if ($sku === '') $errors[] = "SKU is required.";
            if ($name === '') $errors[] = "Name is required.";
            if ($threshold_qty === false || $threshold_qty < 0) $errors[] = "Threshold must be a non-negative integer.";
            if ($current_qty === false || $current_qty < 0) $errors[] = "Quantity must be a non-negative integer.";
            if (Item::skuExists($sku, $client_id, null)) $errors[] = "SKU already exists for this tenant.";

            if (empty($errors)) {
                $item->sku = $sku;
                $item->name = $name;
                $item->threshold_qty = $threshold_qty;
                $item->current_qty = $current_qty;
                if ($item->save()) {
                    $success = true;
                    $_SESSION['success'] = 'Product created successfully!';
                    header('Location: index.php?action=items');
                    exit;
                } else {
                    $errors[] = "Database insert failed.";
                }
            }
        }

        include __DIR__ . '/../Views/Item/addItem.php';
        exit();

    // Show create form and process new item (legacy)
    
}
