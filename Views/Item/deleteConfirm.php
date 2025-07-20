<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-red-600 dark:text-red-400">Confirm Deletion</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Please confirm this action before proceeding</h5>
      </header>
      <div class="flex gap-2">
        <a href="<?= htmlspecialchars($return_url ?? 'index.php?action=items') ?>"
          class="bg-gray-600 hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 text-white flex items-center gap-1 py-2 px-4 rounded-lg font-bold transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Cancel
        </a>
      </div>
    </div>

    <div class="flex flex-col overflow-y-auto h-full">
      <div class="max-w-2xl mx-auto w-full">
        <!-- Warning Alert -->
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6 mb-6">
          <div class="flex items-center gap-3 mb-4">
            <div class="flex-shrink-0">
              <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Warning: This action cannot be undone</h3>
              <p class="text-sm text-red-700 dark:text-red-300">You are about to permanently delete this item from the database.</p>
            </div>
          </div>
        </div>

        <!-- Item Details Card -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6 mb-6">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Item Details
          </h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Name</label>
              <p class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?= htmlspecialchars($item_name ?? 'Unknown Item') ?></p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">SKU</label>
              <p class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?= htmlspecialchars($item_sku ?? 'N/A') ?></p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Current Quantity</label>
              <p class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?= htmlspecialchars($item_qty ?? '0') ?></p>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Threshold</label>
              <p class="text-lg font-semibold text-gray-800 dark:text-gray-200"><?= htmlspecialchars($item_threshold ?? '0') ?></p>
            </div>
          </div>
        </div>

        <!-- Confirmation Form -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
          <form method="POST" action="<?= htmlspecialchars($delete_url ?? 'index.php?action=delete_item') ?>" class="space-y-6">
            <!-- Hidden fields -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($item_id ?? '') ?>">
            <input type="hidden" name="confirmed" value="1">
            <input type="hidden" name="current_page" value="<?= htmlspecialchars($_GET['page'] ?? '1') ?>">
            <?php if (isset($_GET['filter'])): ?>
            <input type="hidden" name="stock_filter" value="<?= htmlspecialchars($_GET['filter']) ?>">
            <?php endif; ?>
            
            <!-- Confirmation checkbox -->
            <div class="flex items-start gap-3">
              <input type="checkbox" 
                     id="confirm_delete" 
                     name="confirm_delete" 
                     required
                     class="mt-1 w-4 h-4 text-red-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-red-500 dark:focus:ring-red-400 focus:ring-2">
              <label for="confirm_delete" class="text-sm text-gray-700 dark:text-gray-300">
                I understand that this action will permanently delete this item and this action cannot be undone.
              </label>
            </div>

            <!-- Type confirmation -->
            <div>
              <label for="type_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Type "DELETE" to confirm
              </label>
              <input type="text" 
                     id="type_confirmation" 
                     name="type_confirmation" 
                     required
                     pattern="DELETE"
                     class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-100 dark:focus:ring-red-900/30 focus:border-red-500 dark:focus:border-red-400 transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                     placeholder="Type DELETE to confirm">
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
              <a href="<?= htmlspecialchars($return_url ?? 'index.php?action=items') ?>"
                 class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-200 font-medium">
                Cancel
              </a>
              <button type="submit"
                      class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                      id="delete_btn"
                      disabled>
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete Permanently
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Enable delete button only when checkbox is checked and confirmation is typed
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('confirm_delete');
    const confirmation = document.getElementById('type_confirmation');
    const deleteBtn = document.getElementById('delete_btn');
    
    function updateButtonState() {
        const isChecked = checkbox.checked;
        const isTyped = confirmation.value === 'DELETE';
        deleteBtn.disabled = !(isChecked && isTyped);
    }
    
    checkbox.addEventListener('change', updateButtonState);
    confirmation.addEventListener('input', updateButtonState);
});
</script>

<?php include('Views/_partials/footer.php'); ?> 