<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="text-white font-bold text-xl">Admin Panel</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="<?php echo URLROOT; ?>/admin/dashboard" 
                           class="<?php echo ($_GET['url'] ?? '') == 'admin/dashboard' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="<?php echo URLROOT; ?>/admin/users" 
                           class="<?php echo ($_GET['url'] ?? '') == 'admin/users' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            Users
                        </a>
                        <a href="<?php echo URLROOT; ?>/admin/courses" 
                           class="<?php echo ($_GET['url'] ?? '') == 'admin/courses' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            Courses
                        </a>
                        <a href="<?php echo URLROOT; ?>/admin/categories" 
                           class="<?php echo ($_GET['url'] ?? '') == 'admin/categories' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> 