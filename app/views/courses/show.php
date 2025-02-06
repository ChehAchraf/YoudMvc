<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Course Header -->
            <div class="relative h-96">
                <?php if($data['course']->thumbnail): ?>
                    <img class="w-full h-full object-cover" 
                         src="<?php echo URLROOT; ?>/uploads/<?php echo $data['course']->thumbnail; ?>" 
                         alt="<?php echo $data['course']->title; ?>">
                <?php else: ?>
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Course Info -->
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    <?php echo $data['course']->title; ?>
                </h1>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-gray-900">
                            $<?php echo number_format($data['course']->price, 2); ?>
                        </span>
                    </div>
                </div>

                <div class="prose max-w-none mb-8">
                    <?php echo $data['course']->description; ?>
                </div>

                <!-- Enrollment Section -->
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <?php if(isLoggedIn()): ?>
                        <?php if($_SESSION['user_role'] === 'student'): ?>
                            <a href="<?php echo URLROOT; ?>/courses/enroll/<?php echo $data['course']->id; ?>" 
                               class="block w-full text-center bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Enroll Now
                            </a>
                        <?php else: ?>
                            <p class="text-center text-gray-600">Only students can enroll in courses</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo URLROOT; ?>/users/login" 
                           class="block text-center w-full bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700">
                            Login to Enroll
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 