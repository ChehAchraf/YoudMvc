<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Course Header -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="relative">
                    <!-- Course Thumbnail -->
                    <div class="h-96 w-full">
                        <?php if($data['course']->thumbnail): ?>
                            <img class="w-full h-full object-cover" 
                                 src="<?php echo URLROOT . '/uploads/' . $data['course']->thumbnail; ?>" 
                                 alt="<?php echo $data['course']->title; ?>">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Course Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            <?php echo $data['course']->status === 'published' ? 'bg-green-100 text-green-800' : 
                                ($data['course']->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800'); ?>">
                            <?php echo ucfirst($data['course']->status); ?>
                        </span>
                    </div>
                </div>

                <!-- Course Info -->
                <div class="p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo $data['course']->title; ?></h1>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span>By <?php echo $data['course']->first_name . ' ' . $data['course']->last_name; ?></span>
                                <span>•</span>
                                <span><?php echo $data['course']->category_name; ?></span>
                                <span>•</span>
                                <div class="flex items-center">
                                    <?php 
                                    $rating = isset($data['course']->avg_rating) ? round($data['course']->avg_rating, 1) : 0;
                                    for($i = 1; $i <= 5; $i++): ?>
                                        <svg class="h-5 w-5 <?php echo $i <= $rating ? 'text-yellow-400' : 'text-gray-300'; ?>" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    <?php endfor; ?>
                                    <span class="ml-1">(<?php echo isset($data['course']->review_count) ? $data['course']->review_count : 0; ?> reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-gray-900">$<?php echo number_format($data['course']->price, 2); ?></p>
                            <?php if(isLoggedIn() && $_SESSION['user_role'] === 'student'): ?>
                                <form action="<?php echo URLROOT; ?>/courses/enroll/<?php echo $data['course']->id; ?>" method="POST">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Enroll Now
                                    </button>
                                </form>
                            <?php elseif(!isLoggedIn()): ?>
                                <a href="<?php echo URLROOT; ?>/users/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Login to Enroll
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                        <div class="prose max-w-none text-gray-500">
                            <?php echo $data['course']->description; ?>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Course Content</h2>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <?php if($data['course']->content_type === 'video'): ?>
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe src="<?php echo $data['course']->content_url; ?>" 
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen></iframe>
                                </div>
                            <?php elseif($data['course']->content_type === 'document'): ?>
                                <div class="flex items-center justify-between p-4 bg-white rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="ml-2 text-gray-600"><?php echo basename($data['course']->file_path); ?></span>
                                    </div>
                                    <a href="<?php echo URLROOT . '/uploads/' . $data['course']->file_path; ?>" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                       download>
                                        Download
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="mt-12">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Student Reviews</h2>
                        
                        <!-- Review Form -->
                        <?php if(isLoggedIn() && $_SESSION['user_role'] === 'student'): ?>
                            <form action="<?php echo URLROOT; ?>/courses/addReview/<?php echo $data['course']->id; ?>" method="POST" class="mb-8">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Rating</label>
                                        <div class="mt-1 flex items-center space-x-1">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <button type="button" onclick="setRating(<?php echo $i; ?>)" 
                                                        class="rating-star text-gray-300 hover:text-yellow-400">
                                                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </button>
                                            <?php endfor; ?>
                                            <input type="hidden" name="rating" id="rating" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="comment" class="block text-sm font-medium text-gray-700">Your Review</label>
                                        <textarea id="comment" name="comment" rows="4" required
                                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    </div>
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>

                        <!-- Reviews List -->
                        <div class="space-y-6">
                            <?php if(!empty($data['course']->reviews)): ?>
                                <?php foreach($data['course']->reviews as $review): ?>
                                    <div class="bg-white rounded-lg shadow p-6">
                                        <div class="flex items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h4 class="text-lg font-medium text-gray-900">
                                                            <?php echo $review->first_name . ' ' . $review->last_name; ?>
                                                        </h4>
                                                        <div class="mt-1 flex items-center">
                                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                                <svg class="h-5 w-5 <?php echo $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300'; ?>" 
                                                                     fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                    <time class="text-sm text-gray-500">
                                                        <?php echo date('M d, Y', strtotime($review->created_at)); ?>
                                                    </time>
                                                </div>
                                                <div class="mt-4 text-sm text-gray-600">
                                                    <?php echo $review->review; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to review this course!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setRating(value) {
    document.getElementById('rating').value = value;
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach((star, index) => {
        star.classList.toggle('text-yellow-400', index < value);
        star.classList.toggle('text-gray-300', index >= value);
    });
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?> 