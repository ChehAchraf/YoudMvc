<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
                <div class="px-4 py-5 sm:px-6 bg-indigo-600">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        Welcome back, <?php echo $data['profile']->first_name; ?>!
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Enrolled Courses</div>
                            <div class="mt-1 text-3xl font-semibold text-indigo-600">
                                <?php echo $data['profile']->enrolled_courses; ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Reviews Given</div>
                            <div class="mt-1 text-3xl font-semibold text-indigo-600">
                                <?php echo $data['profile']->reviews_given; ?>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm font-medium text-gray-500">Total Investment</div>
                            <div class="mt-1 text-3xl font-semibold text-indigo-600">
                                $<?php echo number_format($data['profile']->total_investment, 2); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Courses Section -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        My Courses
                    </h3>
                </div>
                <div class="divide-y divide-gray-200">
                    <?php if(!empty($data['profile']->enrolled_courses_details)): ?>
                        <?php foreach($data['profile']->enrolled_courses_details as $course): ?>
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-20 w-20">
                                        <?php if($course->thumbnail): ?>
                                            <img class="h-20 w-20 object-cover rounded" 
                                                 src="<?php echo URLROOT; ?>/uploads/<?php echo $course->thumbnail; ?>" 
                                                 alt="<?php echo $course->title; ?>">
                                        <?php else: ?>
                                            <div class="h-20 w-20 rounded bg-gray-200 flex items-center justify-center">
                                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-lg font-medium text-gray-900">
                                                    <?php echo $course->title; ?>
                                                </h4>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    By <?php echo $course->first_name . ' ' . $course->last_name; ?>
                                                </p>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    Category: <?php echo $course->category_name; ?>
                                                </p>
                                            </div>
                                            <a href="<?php echo URLROOT; ?>/courses/show/<?php echo $course->id; ?>" 
                                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                View Course
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-6 text-center">
                            <p class="text-gray-500">You haven't enrolled in any courses yet.</p>
                            <a href="<?php echo URLROOT; ?>/courses" 
                               class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Browse Courses
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Activity -->
            <?php /* if(!empty($data['profile']->recent_activities)): ?>
                <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Recent Activity
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php foreach($data['profile']->recent_activities as $activity): ?>
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">
                                            Reviewed <a href="<?php echo URLROOT; ?>/courses/show/<?php echo $activity->course_id; ?>" 
                                                      class="text-indigo-600 hover:text-indigo-900">
                                                <?php echo $activity->course_title; ?>
                                            </a>
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500">
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
            <?php endif; */ ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 