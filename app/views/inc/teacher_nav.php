<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <span class="text-white font-bold text-xl">Teacher Panel</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="<?php echo URLROOT; ?>/teacher/dashboard" 
                           class="<?php echo ($_GET['url'] ?? '') == 'teacher/dashboard' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="<?php echo URLROOT; ?>/teacher/courses" 
                           class="<?php echo ($_GET['url'] ?? '') == 'teacher/courses' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            My Courses
                        </a>
                        <a href="<?php echo URLROOT; ?>/teacher/students" 
                           class="<?php echo ($_GET['url'] ?? '') == 'teacher/students' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            My Students
                        </a>
                        <a href="<?php echo URLROOT; ?>/teacher/earnings" 
                           class="<?php echo ($_GET['url'] ?? '') == 'teacher/earnings' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white'; ?> px-3 py-2 rounded-md text-sm font-medium">
                            Earnings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> 