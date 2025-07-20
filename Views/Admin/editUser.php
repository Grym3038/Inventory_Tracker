<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit User</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Update user information and permissions</h5>
      </header>
      <div class="flex gap-2">
        <a href="index.php?action=users"
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
        <!-- Edit User Form -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
          <form method="POST" action="index.php?action=updateUser" class="space-y-6">
            <input type="hidden" name="user_id" value="<?= (int)$user->id ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Name -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  required
                  value="<?= htmlspecialchars($user->name, ENT_QUOTES) ?>"
                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400"
                >
              </div>

              <!-- Email (read-only) -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  readonly
                  value="<?= htmlspecialchars($user->email, ENT_QUOTES) ?>"
                  class="w-full px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                >
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Email cannot be changed</p>
              </div>

              <!-- Role -->
              <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                <select
                  id="role"
                  name="role"
                  required
                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400"
                >
                  <?php foreach (['admin','owner','manager','employee'] as $roleOpt): ?>
                    <option value="<?= $roleOpt ?>"
                      <?= $user->role === $roleOpt ? 'selected' : '' ?>>
                      <?= ucfirst($roleOpt) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Client -->
              <div>
                <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client</label>
                <select
                  id="client_id"
                  name="client_id"
                  required
                  class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400"
                >
                  <?php foreach ($clients as $c): ?>
                    <option value="<?= (int)$c['id'] ?>"
                      <?= $user->client_id === (int)$c['id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($c['name'], ENT_QUOTES) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>

            <!-- User Info Display -->
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
              <h3 class="font-semibold text-gray-900 dark:text-white mb-3">User Information</h3>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                  <span class="text-gray-600 dark:text-gray-400">User ID:</span>
                  <span class="font-medium text-gray-900 dark:text-white ml-2">#<?= (int)$user->id ?></span>
                </div>
                <div>
                  <span class="text-gray-600 dark:text-gray-400">Created:</span>
                  <span class="font-medium text-gray-900 dark:text-white ml-2">Unknown</span>
                </div>
                <div>
                  <span class="text-gray-600 dark:text-gray-400">Status:</span>
                  <span class="font-medium text-green-600 dark:text-green-400 ml-2">Active</span>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
              <a href="index.php?action=users"
                 class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-all duration-200 font-medium">
                Cancel
              </a>
              <button
                type="submit"
                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
              >
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Changes
              </button>
            </div>
  </form>
</div>

<?php include('Views/_partials/footer.php'); ?>