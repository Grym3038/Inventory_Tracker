<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Add New Product</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Create a new product in your inventory</h5>
      </header>
      <div class="flex gap-2">
        <a href="index.php?action=items"
          class="bg-gray-600 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white flex items-center gap-1 py-2 px-4 rounded-lg font-bold transition">
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
          <div class="bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">Product has been created successfully.</span>
          </div>
        <?php endif; ?>

        <?php if (isset($errors) && count($errors) > 0): ?>
          <div class="bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Error!</strong>
            <ul class="mt-1">
              <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-8">
          <div class="space-y-6">
            <!-- SKU Field -->
            <div class="group">
              <label for="sku" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                SKU *
              </label>
              <div class="relative">
                <input type="text" 
                       id="sku" 
                       name="sku" 
                       value="<?= htmlspecialchars($item->sku ?? '') ?>"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 dark:focus:ring-blue-900/30 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-200 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white"
                       placeholder="Enter product SKU"
                       required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Product Name Field -->
            <div class="group">
              <label for="name" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                Product Name *
              </label>
              <div class="relative">
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($item->name ?? '') ?>"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 dark:focus:ring-green-900/30 focus:border-green-500 dark:focus:border-green-400 transition-all duration-200 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white"
                       placeholder="Enter product name"
                       required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                  <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Threshold Quantity Field -->
              <div class="group">
                <label for="threshold_qty" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                  Threshold Quantity *
                </label>
                <div class="relative">
                  <input type="number" 
                         id="threshold_qty" 
                         name="threshold_qty" 
                         value="<?= htmlspecialchars($item->threshold_qty ?? '0') ?>"
                         min="0"
                         class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/30 focus:border-orange-500 dark:focus:border-orange-400 transition-all duration-200 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white"
                         placeholder="0"
                         required>
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                  </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                  </svg>
                  Minimum quantity before low stock alert
                </p>
              </div>

              <!-- Current Quantity Field -->
              <div class="group">
                <label for="current_qty" class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                  <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                  Current Quantity *
                </label>
                <div class="relative">
                  <input type="number" 
                         id="current_qty" 
                         name="current_qty" 
                         value="<?= htmlspecialchars($item->current_qty ?? '0') ?>"
                         min="0"
                         class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 dark:focus:ring-purple-900/30 focus:border-purple-500 dark:focus:border-purple-400 transition-all duration-200 bg-white/50 dark:bg-gray-700/50 backdrop-blur-sm text-gray-900 dark:text-white"
                         placeholder="0"
                         required>
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-14 0h14"></path>
                    </svg>
                  </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                  </svg>
                  Current stock level
                </p>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
            <a href="index.php?action=items"
               class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-200 font-medium">
              Cancel
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Create Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('Views/_partials/footer.php'); ?> 