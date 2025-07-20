<?php include('Views/_partials/sidebar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold">Products</h1>
        <h5 class="text-sm text-gray-600">Manage your inventory below</h5>
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
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <strong class="font-bold">Success!</strong>
          <span class="block sm:inline"><?= htmlspecialchars($_SESSION['success']) ?></span>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <strong class="font-bold">Error!</strong>
          <ul class="mt-1">
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
      <?php endif; ?>

      <table class="min-w-full bg-white border">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 z-10">
          <tr>
            <th class="px-2 py-3 bg-gray-200 w-8"></th>
            <th class="px-2 py-3 bg-gray-200">Product Name</th>
            <th class="px-2 py-3 bg-gray-200">SKU</th>
            <th class="px-2 py-3 bg-gray-200">Created At</th>
            <th class="px-2 py-3 bg-gray-200">State</th>
            <th class="px-2 py-3 bg-gray-200 w-32">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="px-2 py-2 text-center"><input type="checkbox" class="w-4 h-4"></td>
                <td class="px-2 py-2">
                  <div class="flex items-center gap-2">
                    <?php if (!empty($item->image_url)): ?>
                      <img src="<?= htmlspecialchars($item->image_url) ?>" alt="image" class="aspect-square rounded-lg object-cover h-12">
                    <?php else: ?>
                      <span class="inline-block rounded bg-gray-200 w-12 h-12"></span>
                    <?php endif; ?>
                    <span class="font-bold"><?= htmlspecialchars($item->name) ?></span>
                  </div>
                </td>
                <td class="px-2 py-2 text-center">
                  <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded"><?= htmlspecialchars($item->sku) ?></span>
                </td>
                <td class="px-2 py-2 text-center">
                  <?= !empty($item->created_at) ? htmlspecialchars(date("D, j M Y", strtotime($item->created_at))) : '-' ?>
                </td>
                <td class="px-2 py-2 text-center">
                  <?php
                  if ($item->current_qty == 0) {
                      $state = 'empty';
                      $stateColor = 'bg-red-200 text-red-600';
                  } elseif ($item->current_qty < $item->threshold_qty) {
                      $state = 'low stock';
                      $stateColor = 'bg-orange-200 text-orange-600';
                  } else {
                      $state = 'in stock';
                      $stateColor = 'bg-green-200 text-green-600';
                  }
                  ?>
                  <span class="text-xs font-bold px-2.5 py-2 <?= $stateColor ?> rounded-lg shadow"><?= $state ?></span>
                </td>
                <td class="px-2 py-2 text-center flex gap-1 justify-center">
                  <a href="index.php?action=edit_item&id=<?= $item->id ?>"
                     class="text-blue-600 hover:text-blue-800 font-semibold py-1 px-2 rounded transition">Edit</a>
                  <a href="index.php?action=confirm_delete&id=<?= $item->id ?>&type=item"
                     class="text-red-600 hover:text-red-800 font-semibold py-1 px-2 rounded transition">
                    Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-4 text-gray-400">No products found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="node_modules\flowbite\dist\flowbite.min.js"></script>

</body>


</html>
