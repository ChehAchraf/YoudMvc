<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <!-- Admin Navigation -->
    <?php require APPROOT . '/views/inc/admin_nav.php'; ?>

    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">
                    Dashboard
                </h1>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats -->
                <div class="mt-8">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Total Students -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user-graduate text-2xl text-indigo-600"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Total Students
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">
                                                    <?php echo $data['stats']->total_students; ?>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Teachers -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-chalkboard-teacher text-2xl text-green-600"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Total Teachers
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">
                                                    <?php echo $data['stats']->total_teachers; ?>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Courses -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-book text-2xl text-blue-600"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Total Courses
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">
                                                    <?php echo $data['stats']->total_courses; ?>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Enrollments -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-users text-2xl text-yellow-600"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Total Enrollments
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">
                                                    <?php echo $data['stats']->total_enrollments; ?>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Approvals Section -->
                <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Pending Teachers -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Pending Teacher Approvals
                            </h3>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            <?php foreach($data['pending_teachers'] as $teacher) : ?>
                                <li class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    <?php echo $teacher->first_name . ' ' . $teacher->last_name; ?>
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <?php echo $teacher->email; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="<?php echo URLROOT; ?>/admin/users/approve/<?php echo $teacher->id; ?>" 
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                Approve
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Pending Courses -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Pending Course Reviews
                            </h3>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            <?php foreach($data['pending_courses'] as $course) : ?>
                                <li class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                <?php echo $course->title; ?>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                by <?php echo $course->first_name . ' ' . $course->last_name; ?>
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="<?php echo URLROOT; ?>/admin/courses/approve/<?php echo $course->id; ?>" 
                                               class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                                Approve
                                            </a>
                                            <button onclick="showRejectModal(<?php echo $course->id; ?>)" 
                                                    class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                                Reject
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Reject Course Modal -->
<div id="rejectModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <!-- Modal content -->
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 