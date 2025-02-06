<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?><?php echo isset($data['title']) ? ' - ' . $data['title'] : ''; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/htmx.org@1.9.6"></script>
    <style>
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            margin-top: 0.5rem;
            width: 12rem;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .htmx-indicator {
            display: none;
        }
        .htmx-request .htmx-indicator {
            display: flex;
        }
        .htmx-request.htmx-indicator {
            display: flex;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="<?php echo URLROOT; ?>" class="text-2xl font-bold text-indigo-600">
                            <?php echo SITENAME; ?>
                        </a>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="<?php echo URLROOT; ?>" 
                           class="<?php echo ($_GET['url'] ?? '') === '' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </a>
                        <a href="<?php echo URLROOT; ?>/courses" 
                           class="<?php echo ($_GET['url'] ?? '') === 'courses' ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'; ?> inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Browse Courses
                        </a>
                    </div>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <?php if(isLoggedIn()) : ?>
                        <!-- Show different navigation based on user role -->
                        <?php if($_SESSION['user_role'] === 'admin') : ?>
                            <a href="<?php echo URLROOT; ?>/admin/dashboard" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="<?php echo URLROOT; ?>/admin/users" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                Users
                            </a>
                            <a href="<?php echo URLROOT; ?>/admin/courses" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                Courses
                            </a>
                        <?php elseif($_SESSION['user_role'] === 'teacher') : ?>
                            <a href="<?php echo URLROOT; ?>/teacher/dashboard" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="<?php echo URLROOT; ?>/teacher/courses" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                My Courses
                            </a>
                            <a href="<?php echo URLROOT; ?>/teacher/courses/create" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                Create Course
                            </a>
                        <?php else : ?>
                            <a href="<?php echo URLROOT; ?>/student/dashboard" 
                               class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                                My Learning
                            </a>
                        <?php endif; ?>

                        <!-- User dropdown -->
                        <div class="ml-3 relative">
                            <div class="relative">
                                <button type="button" 
                                        class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                                        id="user-menu-button" 
                                        aria-expanded="false" 
                                        aria-haspopup="true">
                                    <span class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''; ?>
                                        <i class="fas fa-chevron-down ml-2"></i>
                                    </span>
                                </button>
                            </div>

                            <!-- Dropdown menu with role-specific options -->
                            <div class="dropdown-menu rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
                                 role="menu" 
                                 id="user-menu-dropdown" 
                                 aria-orientation="vertical" 
                                 aria-labelledby="user-menu-button"
                                 tabindex="-1">
                                <?php if($_SESSION['user_role'] === 'admin') : ?>
                                    <a href="<?php echo URLROOT; ?>/admin/dashboard" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                       role="menuitem">
                                        <i class="fas fa-tachometer-alt mr-2"></i>
                                        Admin Dashboard
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/admin/users" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                       role="menuitem">
                                        <i class="fas fa-users mr-2"></i>
                                        Manage Users
                                    </a>
                                <?php elseif($_SESSION['user_role'] === 'teacher') : ?>
                                    <a href="<?php echo URLROOT; ?>/teacher/dashboard" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                       role="menuitem">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                                        Teacher Dashboard
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/teacher/courses" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                       role="menuitem">
                                        <i class="fas fa-book mr-2"></i>
                                        My Courses
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo URLROOT; ?>/student/profile" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                       role="menuitem">
                                        <i class="fas fa-user mr-2"></i>
                                        My Profile
                                    </a>
                                    <a href="<?php echo URLROOT; ?>/student/courses" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                       role="menuitem">
                                        <i class="fas fa-graduation-cap mr-2"></i>
                                        My Learning
                                    </a>
                                <?php endif; ?>

                                <!-- Common options for all users -->
                                <div class="border-t border-gray-100"></div>
                                <a href="<?php echo URLROOT; ?>/users/settings" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                   role="menuitem">
                                    <i class="fas fa-cog mr-2"></i>
                                    Settings
                                </a>
                                <a href="<?php echo URLROOT; ?>/users/logout" 
                                   class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50" 
                                   role="menuitem">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/users/login" 
                           class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Sign In
                        </a>
                        <a href="<?php echo URLROOT; ?>/users/register" 
                           class="bg-white text-indigo-600 border border-indigo-600 px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-50">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Add this after your navigation bar -->
    <?php $flash = flash(); ?>
    <?php if($flash): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="rounded-md p-4 <?php echo $flash['class'] === 'success' ? 'bg-green-50' : 'bg-red-50'; ?>">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <?php if($flash['class'] === 'success'): ?>
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        <?php else: ?>
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium <?php echo $flash['class'] === 'success' ? 'text-green-800' : 'text-red-800'; ?>">
                            <?php echo $flash['message']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownButton = document.getElementById('user-menu-button');
            const dropdownMenu = document.getElementById('user-menu-dropdown');

            if (dropdownButton && dropdownMenu) {
                // Toggle dropdown
                dropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                    dropdownButton.setAttribute('aria-expanded', 
                        dropdownButton.getAttribute('aria-expanded') === 'true' ? 'false' : 'true'
                    );
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                        dropdownButton.setAttribute('aria-expanded', 'false');
                    }
                });

                // Close dropdown when pressing Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdownMenu.classList.remove('show');
                        dropdownButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });
    </script>
</body>
</html> 