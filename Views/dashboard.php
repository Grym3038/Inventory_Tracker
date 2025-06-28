<?php include('Views/_partials/sideBar.php'); ?>


        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="user-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="user-profile">
                        <div class="user-avatar">AD</div>
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
                            <div class="stat-value">1,248</div>
                            <div class="stat-label">Total Users</div>
                        </div>
                        <div class="stat-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">342</div>
                            <div class="stat-label">Active Sessions</div>
                        </div>
                        <div class="stat-icon sessions">
                            <i class="fas fa-signal"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">98%</div>
                            <div class="stat-label">System Health</div>
                        </div>
                        <div class="stat-icon health">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <div class="stat-value">5</div>
                            <div class="stat-label">Recent Alerts</div>
                        </div>
                        <div class="stat-icon alerts">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="content-grid">
                <div class="left-column">
                    <!-- Activity Chart -->
                    <div class="chart-container">
                        <div class="section-header">
                            <h3 class="section-title">Activity Overview</h3>
                            <select style="padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                                <option>Last 7 Days</option>
                                <option>Last 30 Days</option>
                                <option>Last 90 Days</option>
                            </select>
                        </div>
                        <div class="chart-placeholder">
                            [Activity Chart Will Appear Here]
                        </div>
                    </div>

                    <!-- Recent Actions -->
                    <div class="recent-actions">
                        <div class="section-header">
                            <h3 class="section-title">Recent Actions</h3>
                            <button style="background: none; border: none; color: var(--primary); cursor: pointer;">
                                View All
                            </button>
                        </div>
                        <div class="actions-list">
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">New user registered</div>
                                    <div class="action-time">2 minutes ago</div>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-file-upload"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">Document uploaded</div>
                                    <div class="action-time">15 minutes ago</div>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">System settings updated</div>
                                    <div class="action-time">1 hour ago</div>
                                </div>
                            </div>
                            <div class="action-item">
                                <div class="action-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="action-details">
                                    <div class="action-title">Security patch applied</div>
                                    <div class="action-time">3 hours ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <!-- System Status -->
                    <div class="system-status">
                        <div class="section-header">
                            <h3 class="section-title">System Status</h3>
                            <i class="fas fa-sync-alt" style="color: var(--gray); cursor: pointer;"></i>
                        </div>
                        <div class="status-list">
                            <div class="status-item">
                                <span class="status-label">Server Uptime</span>
                                <span class="status-value good">99.9%</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">CPU Usage</span>
                                <span class="status-value">32%</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Memory Usage</span>
                                <span class="status-value">45%</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Database</span>
                                <span class="status-value good">Normal</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Last Backup</span>
                                <span class="status-value warning">12 hours ago</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <button class="action-btn">
                            <i class="fas fa-user-plus"></i>
                            <span>Add User</span>
                        </button>
                        <button class="action-btn">
                            <i class="fas fa-file-export"></i>
                            <span>Export Data</span>
                        </button>
                        <button class="action-btn">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </button>
                        <button class="action-btn">
                            <i class="fas fa-question-circle"></i>
                            <span>Help</span>
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
                alert('You have 3 new notifications');
            });

            // User profile dropdown (simplified)
            const userProfile = document.querySelector('.user-profile');
            userProfile.addEventListener('click', function() {
                alert('User profile menu would open here');
            });
        });
</script>

<script src="node_modules\flowbite\dist\flowbite.min.js"></script>

</body>


</html>