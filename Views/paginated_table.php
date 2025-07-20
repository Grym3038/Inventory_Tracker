<?php
require_once('Models/Database.php');
require_once('Models/Item.php');

// Get current page from URL parameter, default to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10; // Number of items per page
$offset = ($current_page - 1) * $items_per_page;

// Get client_id from session (assuming user is logged in)
$client_id = $_SESSION['client_id'] ?? 1; // Default to 1 for demo

// Get total count of items for this client
$db = Models\Database::getConnection();
$count_stmt = $db->prepare('SELECT COUNT(*) FROM items WHERE client_id = :client_id');
$count_stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
$count_stmt->execute();
$total_items = $count_stmt->fetchColumn();

// Calculate total pages
$total_pages = ceil($total_items / $items_per_page);

// Get items for current page
$items_stmt = $db->prepare('
    SELECT id, sku, name, threshold_qty, current_qty, created_at 
    FROM items 
    WHERE client_id = :client_id 
    ORDER BY name 
    LIMIT :limit OFFSET :offset
');
$items_stmt->bindValue(':client_id', $client_id, PDO::PARAM_INT);
$items_stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$items_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$items_stmt->execute();
$items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);

// Helper function to generate pagination links
function generatePaginationLinks($current_page, $total_pages, $base_url = '?action=paginated_table') {
    $links = [];
    
    // Previous page
    if ($current_page > 1) {
        $links[] = '<a href="' . $base_url . '&page=' . ($current_page - 1) . '" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">Previous</a>';
    }
    
    // Page numbers
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 2);
    
    for ($i = $start_page; $i <= $end_page; $i++) {
        $active_class = $i === $current_page ? 'bg-blue-600 text-white' : 'text-gray-500 bg-white hover:bg-gray-50';
        $links[] = '<a href="' . $base_url . '&page=' . $i . '" class="px-3 py-2 text-sm font-medium border border-gray-300 ' . $active_class . '">' . $i . '</a>';
    }
    
    // Next page
    if ($current_page < $total_pages) {
        $links[] = '<a href="' . $base_url . '&page=' . ($current_page + 1) . '" class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">Next</a>';
    }
    
    return implode('', $links);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginated Inventory Table</title>
    <link rel="stylesheet" href="src/output.css" />
    <link rel="stylesheet" href="Lib/CSS/styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Inventory Items</h1>
                <p class="text-sm text-gray-600 mt-1">Showing <?= $offset + 1 ?>-<?= min($offset + $items_per_page, $total_items) ?> of <?= $total_items ?> items</p>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                SKU
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No items found
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($item['name']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= htmlspecialchars($item['sku']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php
                                            // Simple category mapping based on SKU prefix
                                            $category = 'General';
                                            if (strpos($item['sku'], 'SKU-') === 0) {
                                                $category = 'Food & Beverage';
                                            }
                                            echo $category;
                                            ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= $item['current_qty'] ?></div>
                                        <div class="text-xs text-gray-500">Threshold: <?= $item['threshold_qty'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php
                                            // Mock price calculation based on item properties
                                            $base_price = 10.00;
                                            $price = $base_price + (strlen($item['name']) * 0.5);
                                            echo '$' . number_format($price, 2);
                                            ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if ($item['current_qty'] <= $item['threshold_qty']): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Low Stock
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                In Stock
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing <?= $offset + 1 ?> to <?= min($offset + $items_per_page, $total_items) ?> of <?= $total_items ?> results
                        </div>
                        <div class="flex space-x-1">
                            <?= generatePaginationLinks($current_page, $total_pages) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Add any JavaScript functionality here
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Add row click functionality
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    // Add your row click logic here
                    console.log('Row clicked:', this);
                });
            });
        });
    </script>
</body>
</html> 