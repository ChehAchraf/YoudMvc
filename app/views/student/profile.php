<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-indigo-600">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        Student Profile
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-24 w-24">
                            <?php if($data['profile']->avatar): ?>
                                <img class="h-24 w-24 rounded-full" 
                                     src="<?php echo URLROOT; ?>/uploads/avatars/<?php echo $data['profile']->avatar; ?>" 
                                     alt="Profile picture">
                            <?php else: ?>
                                <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-2xl font-medium text-indigo-600">
                                        <?php echo strtoupper(substr($data['profile']->first_name, 0, 1) . substr($data['profile']->last_name, 0, 1)); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="ml-6">
                            <h2 class="text-2xl font-bold text-gray-900">
                                <?php echo $data['profile']->first_name . ' ' . $data['profile']->last_name; ?>
                            </h2>
                            <p class="text-sm text-gray-500">
                                Member since <?php echo date('F Y', strtotime($data['profile']->created_at)); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Enrolled Courses
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            <?php echo $data['profile']->enrolled_courses; ?>
                        </dd>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Reviews Given
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            <?php echo $data['profile']->reviews_given; ?>
                        </dd>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">
                            Average Course Investment
                        </dt>
                        <dd class="mt-1 text-3xl font-semibold text-indigo-600">
                            $<?php echo number_format($data['profile']->avg_course_price ?? 0, 2); ?>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="mt-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    My Courses
                </h3>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <?php foreach($data['profile']->enrolled_courses_details as $course): ?>
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <?php if($course->thumbnail): ?>
                                                <img class="h-16 w-16 object-cover rounded" 
                                                     src="<?php echo URLROOT; ?>/uploads/<?php echo $course->thumbnail; ?>" 
                                                     alt="<?php echo $course->title; ?>">
                                            <?php else: ?>
                                                <div class="h-16 w-16 rounded bg-indigo-100 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-medium text-gray-900">
                                                <?php echo $course->title; ?>
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                By <?php echo $course->first_name . ' ' . $course->last_name; ?>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Enrolled on <?php echo date('M d, Y', strtotime($course->enrollment_date)); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="mr-4">
                                            <div class="flex items-center">
                                                <div class="w-48 h-2 bg-gray-200 rounded-full mr-2">
                                                    <div class="h-2 bg-indigo-600 rounded-full" 
                                                         style="width: <?php echo $course->progress; ?>%"></div>
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    <?php echo $course->progress; ?>%
                                                </span>
                                            </div>
                                        </div>
                                        <a href="<?php echo URLROOT; ?>/courses/learn/<?php echo $course->id; ?>" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                            Continue Learning
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="mt-8">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                    Recent Activity
                </h3>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="divide-y divide-gray-200">
                        <?php foreach($data['profile']->recent_activities as $activity): ?>
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <?php if($activity->type === 'review'): ?>
                                            <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">
                                            Reviewed <a href="<?php echo URLROOT; ?>/courses/show/<?php echo $activity->course_id; ?>" 
                                                      class="text-indigo-600 hover:text-indigo-900">
                                                <?php echo $activity->course_title; ?>
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <?php echo $activity->comment; ?>
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            <?php echo date('M d, Y', strtotime($activity->created_at)); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 