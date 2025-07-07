<?php include('Views/_partials/sideBar.php'); ?>
<div class="flex flex-col grow mx-auto px-4 py-8 h-screen m-auto p-4 items-center pt-10">
  <h1 class="text-3xl font-bold text-center mb-8 m-10">User Listing</h1>

  <!-- Filter Form -->
  <form method="GET" action="index.php" class="flex flex-col md:flex-row justify-between items-center mb-6 w-[70%]">
    <input type="hidden" name="action" value="users">

    <div class="w-full md:w-1/3 mb-4 md:mb-0">
      <select name="client_id" id="client_id" class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">— Select client —</option>
        <?php foreach ($clients as $c): ?>
          <option value="<?= $c['id'] ?>"
            <?= $c['id'] == $clientId ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name'], ENT_QUOTES) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="w-full md:w-1/3 mb-4 md:mb-0">
      <input
        type="text"
        name="email"
        placeholder="Search users by email..."
        value="<?= htmlspecialchars($emailFilter, ENT_QUOTES) ?>"
        class="w-full px-4 py-2 rounded-md border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
    </div>

    <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
      Filter
    </button>
  </form>

  <?php if ($clientId && $totalUsers > 0): ?>
    <!-- Summary -->
    <p class="mb-4">
      Showing <?= count($users) ?> of <?= $totalUsers ?> users for
      <strong>
        <?= htmlspecialchars(array_column(
             array_filter($clients, fn($x)=> $x['id']== $clientId), 'name'
           )[0] ?? 'Unknown', ENT_QUOTES) ?>
      </strong>
    </p>

    <!-- User Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow w-[70%] m-auto p-0">
      <table class="w-full table-auto">
        <thead>
          <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <th class="py-3 px-6 text-left">ID</th>
            <th class="py-3 px-6 text-left">Name</th>
            <th class="py-3 px-6 text-left">Email</th>
            <th class="py-3 px-6 text-left">Role</th>
            <th class="py-3 px-6 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
          <?php foreach ($users as $u): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
              <td class="py-3 px-6 text-left"><?= (int)$u['id'] ?></td>
              <td class="py-3 px-6 text-left"><?= htmlspecialchars($u['name'], ENT_QUOTES) ?></td>
              <td class="py-3 px-6 text-left"><?= htmlspecialchars($u['email'], ENT_QUOTES) ?></td>
              <td class="py-3 px-6 text-left"><?= htmlspecialchars($u['role'], ENT_QUOTES) ?></td>
              <td class="py-3 px-6 text-center">
                <div class="flex item-center justify-center space-x-2">
                  <!-- Edit -->
                  <a href="index.php?action=editUser&id=<?= (int)$u['id'] ?>"
                     class="w-4 transform hover:text-blue-500 hover:scale-110">
                    <!-- pencil icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036
                               a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572
                               L16.732 3.732z" />
                    </svg>
                  </a>
                  <!-- Delete -->
                  <a href="index.php?action=deleteUser&id=<?= (int)$u['id'] ?>"
                     onclick="return confirm('Delete user #<?= (int)$u['id'] ?>?')"
                     class="w-4 transform hover:text-red-500 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                               a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                               m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3
                               M4 7h16" />
                    </svg>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php
      $totalPages = (int)ceil($totalUsers / $perPage);
      if ($totalPages > 1):
    ?>
      <div class="flex justify-between items-center mt-6 w-[70%]">
        <div>
          <span class="text-sm text-gray-700">
            Showing <?= count($users) ?> to
            <?= min($page * $perPage, $totalUsers) ?>
            of <?= $totalUsers ?> entries
          </span>
        </div>
        <div class="flex space-x-2">
          <?php if ($page > 1): ?>
            <a href="index.php?action=users&client_id=<?= $clientId ?>&email=<?= urlencode($emailFilter) ?>&page=<?= $page-1 ?>"
               class="px-3 py-1 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300">
              Previous
            </a>
          <?php endif; ?>

          <?php if ($page < $totalPages): ?>
            <a href="index.php?action=users&client_id=<?= $clientId ?>&email=<?= urlencode($emailFilter) ?>&page=<?= $page+1 ?>"
               class="px-3 py-1 rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300">
              Next
            </a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

  <?php elseif ($clientId): ?>
    <p class="text-red-600">No users found for that client.</p>
  <?php else: ?>
    <p class="text-gray-600">Please select a client to view its users.</p>
  <?php endif; ?>

</div>

<script src="node_modules\flowbite\dist\flowbite.min.js"></script>

</body>


</html>