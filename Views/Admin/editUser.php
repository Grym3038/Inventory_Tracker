<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="flex flex-col grow mx-auto px-4 py-8 h-screen items-center pt-10">
  <h1 class="text-3xl font-bold mb-8">Edit User #<?= (int)$user->id ?></h1>

  <form method="POST" action="index.php?action=updateUser"
        class="w-[50%] bg-white p-6 rounded-lg shadow-md space-y-4">
    <input type="hidden" name="user_id" value="<?= (int)$user->id ?>">

    <!-- Name -->
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
      <input
        type="text"
        id="name"
        name="name"
        required
        value="<?= htmlspecialchars($user->name, ENT_QUOTES) ?>"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
      >
    </div>

    <!-- Email (read-only) -->
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
      <input
        type="email"
        id="email"
        name="email"
        readonly
        value="<?= htmlspecialchars($user->email, ENT_QUOTES) ?>"
        class="mt-1 block w-full px-3 py-2 border border-gray-200 rounded-md bg-gray-100 cursor-not-allowed"
      >
    </div>

    <!-- Role -->
    <div>
      <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
      <select
        id="role"
        name="role"
        required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
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
      <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
      <select
        id="client_id"
        name="client_id"
        required
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
      >
        <?php foreach ($clients as $c): ?>
          <option value="<?= (int)$c['id'] ?>"
            <?= $user->client_id === (int)$c['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name'], ENT_QUOTES) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end space-x-4 pt-4">
      <a href="index.php?action=users"
         class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100">
        Cancel
      </a>
      <button
        type="submit"
        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
      >
        Save Changes
      </button>
    </div>
  </form>
</div>

<?php include('Views/_partials/footer.php'); ?>