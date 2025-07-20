<?php
namespace Controllers;

use Models\Item;
use Models\User;

switch ($action)
{
    // List all items for a client
    case 'items':
    
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
        $client_id = $_SESSION['client_id'] ?? 1; // Use actual session logic
        $items = Item::findAllByClient($client_id);

        include __DIR__ . '/../Views/itemsView.php';
        exit();

    // Show edit form and process update
    case 'edit_item':

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

        $item_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$item_id) {
            $errors[] = "No item ID provided.";
            include __DIR__ . '/../Views/editItem.php';
            return;
        }

        $item = Item::findById($item_id);
        if (!$item) {
            $errors[] = "Item not found.";
            include __DIR__ . '/../Views/editItem.php';
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

        include __DIR__ . '/../Views/editItem.php';
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
        $return_url = 'index.php?action=items';

        include __DIR__ . '/../Views/deleteConfirm.php';
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
        header("Location: index.php?action=items");
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

        include __DIR__ . '/../Views/addItem.php';
        exit();

    // Show create form and process new item (legacy)
    
}
