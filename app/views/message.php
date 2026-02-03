<?php

use app\controllers\UserController;

    if(!isset($_SESSION['user_id'])){
        Flight::redirect("/login");
    }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages & Communication - Modern Bootstrap Admin</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Real-time messaging and communication center with chat interface">
    <meta name="keywords" content="bootstrap, admin, dashboard, messages, chat, communication">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/assets/icons/favicon.svg">
    <link rel="icon" type="image/png" href="/assets/icons/favicon.png">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="/assets/main-QD_VOj1Y.css">


    <!-- Preload critical fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body data-page="messages" class="messages-page" data-current-user-id="<?= $_SESSION['user_id'] ?? 0 ?>">
    <!-- Admin App Container -->
    <div class="admin-app">
        <div class="admin-wrapper" id="admin-wrapper">

            <!-- Header -->
            <header class="admin-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <!-- Logo/Brand -->
                        <a class="navbar-brand d-flex align-items-center" href="./index.html">
                            <img src="/assets/images/logo.svg" alt="Logo" height="32" class="d-inline-block align-text-top me-2">
                            <h1 class="h4 mb-0 fw-bold text-primary">Metis</h1>
                        </a>

                        <!-- Search Bar -->
                        <!-- Search Bar with Alpine.js -->
                        <div class="search-container flex-grow-1 mx-4" id="searchContainer">
                            <div class="position-relative">
                                <input type="search"
                                    class="form-control"
                                    placeholder="Search... (Ctrl+K)"
                                    id="searchInput"
                                    data-search-input
                                    aria-label="Search">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3"></i>

                                <!-- Search Results Dropdown -->
                                <div id="searchResults" class="position-absolute top-100 start-0 w-100 bg-white border rounded-2 shadow-lg mt-1 z-3" style="display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Right Side Icons -->
                        <div class="navbar-nav flex-row">
                            <!-- Theme Toggle with Alpine.js -->
                            <div id="themeSwitch">
                                <button class="btn btn-outline-secondary me-2"
                                    type="button"
                                    id="themeToggle"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    title="Toggle theme">
                                    <i class="bi bi-sun-fill" id="lightIcon"></i>
                                    <i class="bi bi-moon-fill" id="darkIcon" style="display: none;"></i>
                                </button>
                            </div>

                            <!-- Fullscreen Toggle -->
                            <button class="btn btn-outline-secondary me-2"
                                type="button"
                                data-fullscreen-toggle
                                data-bs-toggle="tooltip"
                                data-bs-placement="bottom"
                                title="Toggle fullscreen">
                                <i class="bi bi-arrows-fullscreen icon-hover"></i>
                            </button>

                            <!-- Notifications -->
                            <div class="dropdown me-2" id="notificationBadge">
                                <button class="btn btn-outline-secondary position-relative"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-bell"></i>
                                    <span id="unreadBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">New user registered</a></li>
                                    <li><a class="dropdown-item" href="#">Server status update</a></li>
                                    <li><a class="dropdown-item" href="#">New message received</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                                </ul>
                            </div>

                            <!-- User Menu -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary d-flex align-items-center"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="/assets/images/avatar-placeholder.svg"
                                        alt="User Avatar"
                                        width="24"
                                        height="24"
                                        class="rounded-circle me-2">
                                    <span class="d-none d-md-inline"><?= $_SESSION['user']['username'] ?? "none" ?></span>
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- Sidebar -->
            <aside class="admin-sidebar" id="admin-sidebar">
                <div class="sidebar-content">
                    <nav class="sidebar-nav">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.html">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./analytics.html">
                                    <i class="bi bi-graph-up"></i>
                                    <span>Analytics</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./users.html">
                                    <i class="bi bi-people"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./products.html">
                                    <i class="bi bi-box"></i>
                                    <span>Products</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./orders.html">
                                    <i class="bi bi-bag-check"></i>
                                    <span>Orders</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./forms.html">
                                    <i class="bi bi-ui-checks"></i>
                                    <span>Forms</span>
                                    <span class="badge bg-success rounded-pill ms-auto">New</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#elementsSubmenu" aria-expanded="false">
                                    <i class="bi bi-puzzle"></i>
                                    <span>Elements</span>
                                    <span class="badge bg-primary rounded-pill ms-2 me-2">New</span>
                                    <i class="bi bi-chevron-down ms-auto"></i>
                                </a>
                                <div class="collapse" id="elementsSubmenu">
                                    <ul class="nav nav-submenu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements.html">
                                                <i class="bi bi-grid"></i>
                                                <span>Overview</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-buttons.html">
                                                <i class="bi bi-square"></i>
                                                <span>Buttons</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-alerts.html">
                                                <i class="bi bi-exclamation-triangle"></i>
                                                <span>Alerts</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-badges.html">
                                                <i class="bi bi-award"></i>
                                                <span>Badges</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-cards.html">
                                                <i class="bi bi-card-text"></i>
                                                <span>Cards</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-modals.html">
                                                <i class="bi bi-window"></i>
                                                <span>Modals</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-forms.html">
                                                <i class="bi bi-ui-checks"></i>
                                                <span>Forms</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./elements-tables.html">
                                                <i class="bi bi-table"></i>
                                                <span>Tables</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./reports.html">
                                    <i class="bi bi-file-earmark-text"></i>
                                    <span>Reports</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./message">
                                    <i class="bi bi-chat-dots"></i>
                                    <span>Messages</span>
                                    <span class="badge bg-primary rounded-pill ms-auto">Active</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./calendar.html">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>Calendar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./files.html">
                                    <i class="bi bi-folder2-open"></i>
                                    <span>Files</span>
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <small class="text-muted px-3 text-uppercase fw-bold">Admin</small>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./settings.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./security.html">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Security</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./help.html">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Help & Support</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Floating Hamburger Menu -->
            <button class="hamburger-menu"
                type="button"
                data-sidebar-toggle
                aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Main Content -->
            <main class="admin-main">
                <div class="container-fluid p-4 p-lg-4">

                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h1 class="h3 mb-0">Messages</h1>
                            <p class="text-muted mb-0">Real-time communication center</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary" id="refreshBtn">
                                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                            </button>
                            <button type="button" class="btn btn-primary" id="newMessageBtn">
                                <i class="bi bi-plus-lg me-2"></i>New Message
                            </button>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div class="messages-container">
                        <div class="messages-layout">

                            <!-- Conversations Sidebar -->
                            <div class="messages-sidebar">
                                <!-- Sidebar Header -->
                                <div class="messages-header">
                                    <h5 class="header-title mb-0">Messages</h5>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="search-container flex-grow-1">
                                            <input type="search"
                                                id="searchUsers"
                                                class="form-control"
                                                placeholder="Search conversations...">
                                            <i class="bi bi-search search-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Conversations List -->
                                <div class="conversations-list" id="usersList">
                                    <!-- Conversations will be rendered here by my_script.js -->

                                    <!-- Empty state for conversations -->
                                    <div class="empty-conversations" style="display: none;">
                                        <i class="bi bi-chat-dots"></i>
                                        <p>No conversations found</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Chat Area -->
                            <div class="chat-area" id="conversationView">
                                <!-- Chat will be rendered here by my_script.js -->

                                <!-- Empty Chat State (shown when no conversation selected) -->
                                <div class="empty-chat">
                                    <div class="empty-icon">
                                        <i class="bi bi-chat-dots"></i>
                                    </div>
                                    <h5 class="empty-text">Select a conversation to start messaging</h5>
                                    <p class="text-muted mb-4">Choose from your existing conversations or start a new one</p>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </main>

            <!-- Footer -->
            <footer class="admin-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0 text-muted">© 2025 Modern Bootstrap Admin Template</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-0 text-muted">Built with Bootstrap 5.3.7</p>
                        </div>
                    </div>
                </div>
            </footer>

        </div> <!-- /.admin-wrapper -->
    </div>

    <!-- New Message Modal -->
    <div class="modal fade" id="newMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="search" id="searchAllUsers" class="form-control" placeholder="Search users...">
                    </div>
                    <div id="allUsersList">
                        <!-- Users list will be rendered here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page-specific Script -->
    <script src="/scripts/js/bootstrap.bundle.min.js" nonce="<?= $csp_nonce ?>"></script>
    <script src="/scripts/js/my_script.js" nonce="<?= $csp_nonce ?>"></script>

    <script nonce="<?= $csp_nonce ?>">
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', () => {
            const lightIcon = document.getElementById('lightIcon');
            const darkIcon = document.getElementById('darkIcon');

            // Initialize theme from localStorage
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);

            // Update icon on page load
            if (savedTheme === 'dark') {
                lightIcon.style.display = 'none';
                darkIcon.style.display = 'inline-block';
            } else {
                lightIcon.style.display = 'inline-block';
                darkIcon.style.display = 'none';
            }

            // Theme toggle button handler
            const themeToggle = document.querySelector('[data-bs-toggle="tooltip"][title*="theme"]');
            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-bs-theme', newTheme);
                    localStorage.setItem('theme', newTheme);

                    // Toggle icons
                    if (newTheme === 'dark') {
                        lightIcon.style.display = 'none';
                        darkIcon.style.display = 'inline-block';
                    } else {
                        lightIcon.style.display = 'inline-block';
                        darkIcon.style.display = 'none';
                    }
                });
            }

            // Sidebar toggle
            const toggleButton = document.querySelector('[data-sidebar-toggle]');
            const wrapper = document.getElementById('admin-wrapper');

            if (toggleButton && wrapper) {
                const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                if (isCollapsed) {
                    wrapper.classList.add('sidebar-collapsed');
                    toggleButton.classList.add('is-active');
                }

                toggleButton.addEventListener('click', () => {
                    const isCurrentlyCollapsed = wrapper.classList.contains('sidebar-collapsed');

                    if (isCurrentlyCollapsed) {
                        wrapper.classList.remove('sidebar-collapsed');
                        toggleButton.classList.remove('is-active');
                        localStorage.setItem('sidebar-collapsed', 'false');
                    } else {
                        wrapper.classList.add('sidebar-collapsed');
                        toggleButton.classList.add('is-active');
                        localStorage.setItem('sidebar-collapsed', 'true');
                    }
                });
            }
        });
    </script>
</body>

</html>