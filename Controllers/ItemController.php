<?php
namespace Controllers;

use Models\Item;

class ItemController
{
    // List all items for a client
    public function index()
    {
        $client_id = $_SESSION['client_id'] ?? 1; // Use actual session logic
        $items = Item::findAllByClient($client_id);

        include __DIR__ . '/../Views/items.php';
    }

    // Show edit form and process update
    public function edit()
    {
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
    }

    // Handle deleting an item
    public function delete()
    {
        $item_id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($item_id) {
            $item = Item::findById($item_id);
            if ($item) {
                $item->delete();
            }
        }
        header("Location: index.php?action=items");
        exit;
    }

    // Show create form and process new item
    public function create()
    {
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
                    // Optionally redirect to list or clear form
                } else {
                    $errors[] = "Database insert failed.";
                }
            }
        }

        include __DIR__ . '/../Views/editItem.php'; // reuse form view for create
    }
}
