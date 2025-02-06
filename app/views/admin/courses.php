<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <!-- Admin Navigation -->
    <?php require APPROOT . '/views/inc/admin_nav.php'; ?>

    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">
                    Manage Courses
                </h1>
            </div>
        </header>
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Message -->
                <?php flash('admin_message'); ?>

                <!-- Courses Table -->
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Course
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Instructor
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Stats
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach($data['courses'] as $course): ?>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <?php if($course->thumbnail): ?>
                                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                                     src="<?php echo URLROOT . '/uploads/' . $course->thumbnail; ?>" 
                                                                     alt="">
                                                            <?php else: ?>
                                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <?php echo $course->title; ?>
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                $<?php echo number_format($course->price, 2); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo $course->first_name . ' ' . $course->last_name; ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        <?php echo $course->category_name; ?>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        <?php echo $course->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                            ($course->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                                                            'bg-red-100 text-red-800'); ?>">
                                                        <?php echo ucfirst($course->status); ?>
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div>Enrollments: <?php echo $course->enrollment_count; ?></div>
                                                    <div>Rating: <?php echo number_format($course->avg_rating, 1); ?>/5</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <form action="<?php echo URLROOT; ?>/admin/courses/updateStatus/<?php echo $course->id; ?>" 
                                                          method="POST" class="inline-block">
                                                        <?php if($course->status !== 'published'): ?>
                                                            <button type="submit" name="status" value="published"
                                                                    class="text-green-600 hover:text-green-900 mr-3">
                                                                Approve
                                                            </button>
                                                        <?php endif; ?>
                                                        <?php if($course->status !== 'rejected'): ?>
                                                            <button type="submit" name="status" value="rejected"
                                                                    class="text-red-600 hover:text-red-900">
                                                                Reject
                                                            </button>
                                                        <?php endif; ?>
                                                    </form>
                                                    <a href="<?php echo URLROOT; ?>/courses/show/<?php echo $course->id; ?>" 
                                                       class="text-indigo-600 hover:text-indigo-900 ml-3">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 