<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">User Management</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Manage users and their permissions</h5>
      </header>
      <div class="flex gap-2">
        <a href="index.php?action=add_user"
          class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white flex items-center gap-1 py-2 px-4 rounded-lg font-bold transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
          <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Add User
        </a>
      </div>
    </div>

    <div class="flex flex-col overflow-y-auto h-full">
      <!-- Filter Form -->
      <form method="GET" action="index.php" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6 mb-6">
        <input type="hidden" name="action" value="users">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Client</label>
            <select name="client_id" id="client_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400">
              <option value="">— Select client —</option>
              <?php foreach ($clients as $c): ?>
                <option value="<?= $c['id'] ?>"
                  <?= $c['id'] == $clientId ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c['name'], ENT_QUOTES) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Email</label>
            <input
              type="text"
              name="email"
              id="email"
              placeholder="Search users by email..."
              value="<?= htmlspecialchars($emailFilter, ENT_QUOTES) ?>"
              class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400"
            >
          </div>

          <div class="flex items-end">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 font-medium">
              Filter Users
            </button>
          </div>
        </div>
      </form>

      <?php if ($clientId && $totalUsers > 0): ?>
        <!-- Summary -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-200 px-4 py-3 rounded-lg mb-6">
          <p class="text-sm">
            Showing <?= $totalUsers ?> user<?= $totalUsers !== 1 ? 's' : '' ?> for 
            <strong><?= htmlspecialchars($selectedClientName) ?></strong>
          </p>
        </div>
      <?php endif; ?>

      <!-- Users Table -->
      <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-lg">
        <table class="min-w-full">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    <?= htmlspecialchars($user['id']) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    <?= htmlspecialchars($user['name']) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    <?= htmlspecialchars($user['email']) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                      <?php
                      switch ($user['role']) {
                        case 'admin':
                          echo 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200';
                          break;
                        case 'owner':
                          echo 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200';
                          break;
                        case 'employee':
                          echo 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200';
                          break;
                        default:
                          echo 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
                      }
                      ?>">
                      <?= ucfirst(htmlspecialchars($user['role'])) ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    <div class="flex items-center justify-center space-x-2">
                      <a href="index.php?action=edit_user&id=<?= $user['id'] ?>" 
                         class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                         title="Edit User">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                      </a>
                      <a href="index.php?action=confirm_delete_user&id=<?= $user['id'] ?>&type=user&page=<?= $page ?>&client_id=<?= $clientId ?>&email=<?= urlencode($emailFilter) ?>" 
                         class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                         title="Delete User">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                  <div class="flex flex-col items-center gap-2">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span class="text-lg font-medium">No users found</span>
                    <span class="text-sm">Select a client to view users</span>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include('Views/_partials/footer.php'); ?>