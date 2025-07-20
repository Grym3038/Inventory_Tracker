<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Confirm User Deletion</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Are you sure you want to delete this user?</h5>
      </header>
      <div class="flex gap-2">
        <a href="<?= $return_url ?>"
          class="bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white flex items-center gap-1 py-2 px-4 rounded-lg font-bold transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          Back to Users
        </a>
      </div>
    </div>

    <div class="flex flex-col overflow-y-auto h-full">
      <div class="max-w-2xl mx-auto w-full">
        <!-- Delete Confirmation Card -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
          <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
              </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Delete User</h2>
            <p class="text-gray-600 dark:text-gray-400">This action cannot be undone. The user will be permanently removed from the system.</p>
          </div>

          <!-- User Details -->
          <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">User Details</h3>
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Name:</span>
                <span class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($user_name) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Email:</span>
                <span class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($user_email) ?></span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Role:</span>
                <span class="font-medium text-gray-900 dark:text-white"><?= ucfirst(htmlspecialchars($user_role)) ?></span>
              </div>
            </div>
          </div>

          <!-- Confirmation Form -->
          <form method="POST" action="<?= $delete_url ?>" class="space-y-4">
            <input type="hidden" name="id" value="<?= $userId ?>">
            <input type="hidden" name="confirmed" value="1">
            <input type="hidden" name="current_page" value="<?= $current_page ?>">
            <input type="hidden" name="client_filter" value="<?= $client_filter ?>">
            <input type="hidden" name="email_filter" value="<?= htmlspecialchars($email_filter) ?>">
            
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Warning</h3>
                  <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                    <p>Deleting this user will:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                      <li>Remove all their access to the system</li>
                      <li>Delete their account permanently</li>
                      <li>This action cannot be undone</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
              <label class="flex items-center">
                <input type="checkbox" name="confirm_delete" value="DELETE" required 
                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                  I understand that this action cannot be undone and I want to delete this user
                </span>
              </label>
            </div>

            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
              <label class="flex items-center">
                <input type="text" name="type_confirmation" placeholder="Type DELETE to confirm" required 
                       class="w-full px-3 py-2 border border-red-300 dark:border-red-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:border-red-500 dark:focus:border-red-400"
                       pattern="DELETE" title="Please type DELETE to confirm">
              </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
              <a href="<?= $return_url ?>"
                 class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-200 font-medium">
                Cancel
              </a>
              <button type="submit"
                      class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Delete User
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('Views/_partials/footer.php'); ?> 