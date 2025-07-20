<?php
// User variables are now set by the controller
?>

<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

<div class="w-full h-full col-span-7">
  <div class="w-full flex flex-col overflow-y-auto p-4 bg-white dark:bg-gray-900">
    <div class="w-full flex items-center justify-between">
      <header class="py-4 flex flex-col">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Settings</h1>
        <h5 class="text-sm text-gray-600 dark:text-gray-400">Manage your account preferences</h5>
      </header>
    </div>

    <!-- Display success/error messages -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        <?php foreach ($_SESSION['success'] as $message): ?>
          <p><?= htmlspecialchars($message) ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['errors'])): ?>
      <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <?php foreach ($_SESSION['errors'] as $message): ?>
          <p><?= htmlspecialchars($message) ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>

    <div class="flex flex-col overflow-y-auto h-full">
      <div class="max-w-4xl mx-auto w-full">
        
        <!-- User Profile Card -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6 mb-6">
          <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-xl">
              <?php
              // Generate initials from user name
              $initials = implode('', array_map(
                  fn($part) => mb_strtoupper(mb_substr($part, 0, 1)),
                  preg_split('/[\s\-]+/', $user_name)
              ));
              echo $initials;
              ?>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($user_name) ?></h3>
              <p class="text-sm text-gray-600 dark:text-gray-400"><?= htmlspecialchars($user_email) ?></p>
              <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                <?= ucfirst(htmlspecialchars($user_role)) ?>
              </span>
            </div>
          </div>
        </div>

        <!-- Settings Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          
          <!-- Profile Settings -->
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              Profile
            </h3>
            
            <div class="space-y-4">
              <form method="POST" class="space-y-3">
                <div>
                  <label for="new_name" class="block text-sm font-medium text-gray-900 dark:text-white mb-1">Display Name</label>
                  <input type="text" id="new_name" name="new_name" value="<?= htmlspecialchars($user_name) ?>" 
                         class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" name="update_name" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                  Update Name
                </button>
              </form>
            </div>
          </div>

          <!-- Appearance Settings -->
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
              </svg>
              Appearance
            </h3>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Dark Mode</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Switch between light and dark themes</p>
                </div>
                <form method="POST" class="flex items-center" id="darkModeForm">
                  <input type="hidden" name="dark_mode_value" id="darkModeValue" value="<?= $is_dark_mode ? '1' : '0' ?>">
                  <label class="toggle-switch">
                    <input type="checkbox" id="darkModeToggle" <?= $is_dark_mode ? 'checked' : '' ?> onchange="updateDarkMode()">
                    <span class="slider"></span>
                  </label>
                </form>
              </div>
            </div>
          </div>

          <!-- Account Settings -->
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              Account
            </h3>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Change Password</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Update your account password</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                  Update
                </button>
              </div>
              
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Email Notifications</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Manage email preferences</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                  Configure
                </button>
              </div>
            </div>
          </div>

          <!-- Security Settings -->
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              Security
            </h3>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Two-Factor Authentication</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Add an extra layer of security</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                  Enable
                </button>
              </div>
              
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Login History</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">View recent login activity</p>
                </div>
                <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                  View
                </button>
              </div>
            </div>
          </div>

          <!-- System Settings -->
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-xl rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
              System
            </h3>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Language</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Change interface language</p>
                </div>
                <select class="text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                  <option value="en">English</option>
                  <option value="es">Spanish</option>
                  <option value="fr">French</option>
                </select>
              </div>
              
              <div class="flex items-center justify-between">
                <div>
                  <h4 class="text-sm font-medium text-gray-900 dark:text-white">Time Zone</h4>
                  <p class="text-xs text-gray-500 dark:text-gray-400">Set your local time zone</p>
                </div>
                <select class="text-sm border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                  <option value="UTC">UTC</option>
                  <option value="EST">Eastern Time</option>
                  <option value="PST">Pacific Time</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
        /* Toggle switch styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: #2196F3;
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        
        .dark .slider {
            background-color: #6b7280;
        }
        
        .dark input:checked + .slider {
            background-color: #3b82f6;
        }
    </style>

<script>
function updateDarkMode() {
    const toggle = document.getElementById('darkModeToggle');
    const hiddenInput = document.getElementById('darkModeValue');
    const form = document.getElementById('darkModeForm');
    
    // Update the hidden input value based on checkbox state
    hiddenInput.value = toggle.checked ? '1' : '0';
    
    // Submit the form
    form.submit();
}
</script>

<?php include('Views/_partials/footer.php'); ?> 