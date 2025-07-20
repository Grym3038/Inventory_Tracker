<?php include('Views/_partials/dashboardHeader.php'); ?>
<?php include('Views/_partials/sideBar.php'); ?>

        <!-- Main Content -->
        <div class="main-content ">
            <!-- Header -->
            <div class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search inventory...">
                </div>
                <div class="user-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="user-profile" style="cursor: pointer;" onclick="window.location.href='?action=settings'">
                        <div class="user-avatar"><?php
                        // Split the full name on spaces/hyphens, take each first letter, uppercase it, then join
                        echo implode('', array_map(
                            fn($part) => mb_strtoupper(mb_substr($part, 0, 1)),
                            preg_split('/[\s\-]+/', $_SESSION['name'] ?? '')
                        ));
                        ?></div>
                        <span><?= $_SESSION["name"] ?></span>
                        <i class="fas fa-chevron-down" style="margin-left: 10px;"></i>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">1,247</div>
                            <div class="stat-label">Total Items</div>
                        </div>
                        <div class="stat-icon users">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">23</div>
                            <div class="stat-label">Low Stock Items</div>
                        </div>
                        <div class="stat-icon sessions">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">8</div>
                            <div class="stat-label">Out of Stock</div>
                        </div>
                        <div class="stat-icon health">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">$45,230</div>
                            <div class="stat-label">Inventory Value</div>
                        </div>
                        <div class="stat-icon alerts">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="content-grid">
                <div class="left-column">
                    <!-- Inventory Activity Chart -->
                    <div class="chart-container">
                        <div class="section-header">
                            <h3 class="section-title">Inventory Activity</h3>
                            <select style="padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                                <option>Last 7 Days</option>
                                <option>Last 30 Days</option>
                                <option>Last 90 Days</option>
                            </select>
                        </div>
                        <div class="chart-placeholder">
                            [Inventory Activity Chart Will Appear Here]
                        </div>
                    </div>

                    <!-- Recent Inventory Actions -->
                    <div class="recent-actions">
                        <div class="section-header">
                            <h3 class="section-title">Recent Inventory Actions</h3>
                            <button style="background: none; border: none; color: var(--primary); cursor: pointer;">
                                View All
                            </button>
                        </div>
                        <div class="actions-list">
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">New item added: "Wireless Headphones"</div>
                                    <div class="action-time">2 minutes ago</div>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">Quantity updated: "Laptop Chargers" (+15 units)</div>
                                    <div class="action-time">15 minutes ago</div>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">Low stock alert: "USB Cables" (5 remaining)</div>
                                    <div class="action-time">1 hour ago</div>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-trash"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">Item removed: "Obsolete Keyboard Model"</div>
                                    <div class="action-time">3 hours ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <!-- Inventory Status -->
                    <div class="system-status">
                        <div class="section-header">
                            <h3 class="section-title">Inventory Status</h3>
                            <i class="fas fa-sync-alt" style="color: var(--gray); cursor: pointer;"></i>
                        </div>
                        <div class="status-list">
                            <div class="status-item">
                                <span class="status-label">Items in Stock</span>
                                <span class="status-value good">1,216</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Low Stock Items</span>
                                <span class="status-value warning">23</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Out of Stock</span>
                                <span class="status-value">8</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Categories</span>
                                <span class="status-value good">12</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Last Inventory Check</span>
                                <span class="status-value warning">2 days ago</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <button class="action-btn" onclick="window.location.href='?action=add_item'">
                            <i class="fas fa-plus"></i>
                            <span>Add Item</span>
                        </button>
                        <button class="action-btn" onclick="window.location.href='?action=items'">
                            <i class="fas fa-boxes"></i>
                            <span>View Inventory</span>
                        </button>
                        <button class="action-btn" onclick="window.location.href='?action=users'">
                            <i class="fas fa-users"></i>
                            <span>Manage Users</span>
                        </button>
                        <button class="action-btn" onclick="window.location.href='?action=settings'">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Menu item click handler
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Notification click handler
            const notification = document.querySelector('.notification');
            notification.addEventListener('click', function() {
                alert('You have 3 new inventory alerts');
            });

        });
    </script>

<?php include('Views/_partials/footer.php'); ?>