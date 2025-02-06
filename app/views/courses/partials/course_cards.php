<?php foreach($data['courses'] as $course): ?>
    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
        <div class="h-48 relative">  <!-- Fixed height container -->
            <?php if($course->thumbnail && file_exists(PUBLICPATH . '/uploads/' . $course->thumbnail)): ?>
                <img class="w-full h-full object-cover" 
                     src="<?php echo URLROOT . '/uploads/' . $course->thumbnail; ?>" 
                     alt="<?php echo $course->title; ?>">
            <?php else: ?>
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        <div class="p-4">
            <h3 class="text-lg font-medium text-gray-900 truncate">
                <?php echo $course->title; ?>
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                By <?php echo $course->first_name . ' ' . $course->last_name; ?>
            </p>
            <div class="mt-2 flex items-center">
                <?php 
                $rating = isset($course->avg_rating) ? round($course->avg_rating, 1) : 0;
                for($i = 1; $i <= 5; $i++): ?>
                    <svg class="h-5 w-5 <?php echo $i <= $rating ? 'text-yellow-400' : 'text-gray-300'; ?>" 
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                <?php endfor; ?>
                <span class="ml-1 text-sm text-gray-500">
                    (<?php echo $course->review_count ?? 0; ?>)
                </span>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-lg font-bold text-gray-900">
                    $<?php echo number_format($course->price, 2); ?>
                </span>
                <a href="<?php echo URLROOT; ?>/courses/show/<?php echo $course->id; ?>" 
                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    View Course
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?> 