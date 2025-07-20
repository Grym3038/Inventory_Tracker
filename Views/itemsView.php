<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Products</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Manage your inventory below</h5>
      </header>
      <div class="flex gap-2">
        <a href="index.php?action=add_item"
          class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white flex items-center gap-1 py-2 px-4 rounded-lg font-bold transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
          <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add Item
        </a>
      </div>
    </div>
    <div class="flex flex-col overflow-y-auto h-full">
      <!-- Success/Error Messages -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
          <strong class="font-bold">Success!</strong>
          <span class="block sm:inline"><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0): ?>
        <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
          <strong class="font-bold">Error!</strong>
          <ul class="mt-1">
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
      <?php endif; ?>

      <!-- Items Count and Pagination Info -->
      <div class="flex justify-between items-center mb-4 text-sm text-gray-600 dark:text-gray-400">
        <div>
          Showing <?= (($pagination['current_page'] - 1) * $pagination['per_page']) + 1 ?> to 
          <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_items']) ?> 
          of <?= $pagination['total_items'] ?> items
        </div>
        <div class="text-sm">
          Page <?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?>
        </div>
      </div>

      <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700 sticky top-0 z-10">
          <tr>
            <th class="px-2 py-3 bg-gray-200 dark:bg-gray-600 w-8"></th>
            <th class="px-2 py-3 bg-gray-200 dark:bg-gray-600">Product Name</th>
            <th class="px-2 py-3 bg-gray-200 dark:bg-gray-600">SKU</th>
            <th class="px-2 py-3 bg-gray-200 dark:bg-gray-600">Created At</th>
            <th class="px-2 py-3 bg-gray-200 dark:bg-gray-600">State</th>
            <th class="px-2 py-3 bg-gray-200 dark:bg-gray-600 w-32">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
          <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
              <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <td class="px-2 py-2 text-center">
                  <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                </td>
                <td class="px-2 py-2">
                  <div class="flex items-center gap-2">
                    <?php if (!empty($item->image_url)): ?>
                      <img src="<?= htmlspecialchars($item->image_url) ?>" alt="image" class="aspect-square rounded-lg object-cover h-12">
                    <?php else: ?>
                      <span class="inline-block rounded bg-gray-200 dark:bg-gray-600 w-12 h-12"></span>
                    <?php endif; ?>
                    <span class="font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($item->name) ?></span>
                  </div>
                </td>
                <td class="px-2 py-2 text-center">
                  <span class="font-mono text-sm bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded"><?= htmlspecialchars($item->sku) ?></span>
                </td>
                <td class="px-2 py-2 text-center text-gray-700 dark:text-gray-300">
                  <?= !empty($item->created_at) ? htmlspecialchars(date("D, j M Y", strtotime($item->created_at))) : '-' ?>
                </td>
                <td class="px-2 py-2 text-center">
                  <?php
                  if ($item->current_qty == 0) {
                      $state = 'empty';
                      $stateColor = 'bg-red-200 dark:bg-red-900/30 text-red-600 dark:text-red-400';
                  } elseif ($item->current_qty < $item->threshold_qty) {
                      $state = 'low stock';
                      $stateColor = 'bg-orange-200 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400';
                  } else {
                      $state = 'in stock';
                      $stateColor = 'bg-green-200 dark:bg-green-900/30 text-green-600 dark:text-green-400';
                  }
                  ?>
                  <span class="text-xs font-bold px-2.5 py-2 <?= $stateColor ?> rounded-lg shadow"><?= $state ?></span>
                </td>
                <td class="px-2 py-2 text-center flex gap-1 justify-center">
                  <a href="index.php?action=edit_item&id=<?= $item->id ?>"
                     class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold py-1 px-2 rounded transition">Edit</a>
                  <a href="index.php?action=confirm_delete&id=<?= $item->id ?>&type=item&page=<?= $pagination['current_page'] ?>"
                     class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-semibold py-1 px-2 rounded transition">
                    Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-8 text-gray-400 dark:text-gray-500">
                <div class="flex flex-col items-center gap-2">
                  <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                  </svg>
                  <span class="text-lg font-medium">No products found.</span>
                  <span class="text-sm">Add your first product to get started.</span>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Pagination Controls -->
      <?php if ($pagination['total_pages'] > 1): ?>
        <div class="flex items-center justify-between mt-6">
          <div class="flex items-center gap-2">
            <span class="text-sm text-gray-700 dark:text-gray-300">Items per page:</span>
            <select class="text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
              <option value="10" <?= $pagination['per_page'] == 10 ? 'selected' : '' ?>>10</option>
              <option value="25" <?= $pagination['per_page'] == 25 ? 'selected' : '' ?>>25</option>
              <option value="50" <?= $pagination['per_page'] == 50 ? 'selected' : '' ?>>50</option>
            </select>
          </div>
          
          <div class="flex items-center gap-2">
            <!-- Previous Page -->
            <?php if ($pagination['has_previous']): ?>
              <a href="index.php?action=items&page=<?= $pagination['previous_page'] ?>" 
                 class="px-3 py-2 text-sm font-medium text-gray-500 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                Previous
              </a>
            <?php else: ?>
              <span class="px-3 py-2 text-sm font-medium text-gray-300 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md cursor-not-allowed">
                Previous
              </span>
            <?php endif; ?>

            <!-- Page Numbers -->
            <div class="flex items-center gap-1">
              <?php
              $start_page = max(1, $pagination['current_page'] - 2);
              $end_page = min($pagination['total_pages'], $pagination['current_page'] + 2);
              
              if ($start_page > 1): ?>
                <a href="index.php?action=items&page=1" 
                   class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                  1
                </a>
                <?php if ($start_page > 2): ?>
                  <span class="px-2 py-2 text-sm text-gray-500 dark:text-gray-400">...</span>
                <?php endif; ?>
              <?php endif; ?>

              <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($i == $pagination['current_page']): ?>
                  <span class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-md">
                    <?= $i ?>
                  </span>
                <?php else: ?>
                  <a href="index.php?action=items&page=<?= $i ?>" 
                     class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                    <?= $i ?>
                  </a>
                <?php endif; ?>
              <?php endfor; ?>

              <?php if ($end_page < $pagination['total_pages']): ?>
                <?php if ($end_page < $pagination['total_pages'] - 1): ?>
                  <span class="px-2 py-2 text-sm text-gray-500 dark:text-gray-400">...</span>
                <?php endif; ?>
                <a href="index.php?action=items&page=<?= $pagination['total_pages'] ?>" 
                   class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                  <?= $pagination['total_pages'] ?>
                </a>
              <?php endif; ?>
            </div>

            <!-- Next Page -->
            <?php if ($pagination['has_next']): ?>
              <a href="index.php?action=items&page=<?= $pagination['next_page'] ?>" 
                 class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                Next
              </a>
            <?php else: ?>
              <span class="px-3 py-2 text-sm font-medium text-gray-300 dark:text-gray-600 bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md cursor-not-allowed">
                Next
              </span>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<script src="node_modules\flowbite\dist\flowbite.min.js"></script>

</body>


</html>
