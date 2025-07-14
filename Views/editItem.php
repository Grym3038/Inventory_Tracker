<?php include('Views/_partials/sidebar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold"><?= empty($item->id) ? 'Add New Product' : 'Edit Product' ?></h1>
        <h5 class="text-sm text-gray-600"><?= empty($item->id) ? 'Create a new product in your inventory' : 'Update product information' ?></h5>
      </header>
      <div class="flex gap-2">
        <a href="index.php?action=items"
          class="bg-gray-600 hover:bg-gray-800 text-white flex items-center gap-1 py-2 px-4 rounded-lg font-bold transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Products
        </a>
      </div>
    </div>

    <div class="flex flex-col overflow-y-auto h-full">
      <div class="max-w-2xl mx-auto w-full">
        <?php if (isset($success) && $success): ?>
          <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">Product has been <?= empty($item->id) ? 'created' : 'updated' ?> successfully.</span>
          </div>
        <?php endif; ?>

        <?php if (isset($errors) && count($errors) > 0): ?>
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Error!</strong>
            <ul class="mt-1">
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST" class="bg-white/80 backdrop-blur-sm border border-gray-200/50 shadow-xl rounded-2xl p-8">
          <?php if (!empty($item->id)): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($item->id) ?>">
          <?php endif; ?>
          
          <!-- Debug info - remove this later -->
          <?php if (isset($item)): ?>
            <div class="mb-6 p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl">
              Debug: Item ID = <?= $item->id ?? 'null' ?>
            </div>
          <?php else: ?>
            <div class="mb-6 p-3 bg-red-50 border border-red-200 text-red-800 rounded-xl">
              Debug: $item variable is not set
            </div>
          <?php endif; ?>

          <div class="space-y-6">
            <!-- SKU Field -->
            <div class="group">
              <label for="sku" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                SKU *
              </label>
              <div class="relative">
                <input type="text" 
                       id="sku" 
                       name="sku" 
                       value="<?= htmlspecialchars($item->sku ?? '') ?>"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                       placeholder="Enter product SKU"
                       required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Product Name Field -->
            <div class="group">
              <label for="name" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                Product Name *
              </label>
              <div class="relative">
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($item->name ?? '') ?>"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                       placeholder="Enter product name"
                       required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Threshold Quantity Field -->
              <div class="group">
                <label for="threshold_qty" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                  Threshold Quantity *
                </label>
                <div class="relative">
                  <input type="number" 
                         id="threshold_qty" 
                         name="threshold_qty" 
                         value="<?= htmlspecialchars($item->threshold_qty ?? '0') ?>"
                         min="0"
                         class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                         placeholder="0"
                         required>
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                  </svg>
                  Minimum quantity before low stock alert
                </p>
              </div>

              <!-- Current Quantity Field -->
              <div class="group">
                <label for="current_qty" class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                  Current Quantity *
                </label>
                <div class="relative">
                  <input type="number" 
                         id="current_qty" 
                         name="current_qty" 
                         value="<?= htmlspecialchars($item->current_qty ?? '0') ?>"
                         min="0"
                         class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                         placeholder="0"
                         required>
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14"></path>
                    </svg>
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                  </svg>
                  Current stock level
                </p>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200/50">
            <a href="index.php?action=items"
               class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
              Cancel
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
              </svg>
              Save Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="node_modules\flowbite\dist\flowbite.min.js"></script>

</body>
</html> 