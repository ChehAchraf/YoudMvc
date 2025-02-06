<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="relative bg-indigo-800">
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover" src="<?php echo URLROOT; ?>/img/bg.jpg" alt="Education background">
        <div class="absolute inset-0 bg-indigo-800 mix-blend-multiply" aria-hidden="true"></div>
    </div>
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Transform your life through education</h1>
        <p class="mt-6 text-xl text-indigo-100 max-w-3xl">
            Learners around the world are launching new careers, advancing in their fields, and enriching their lives.
        </p>
        <div class="mt-10 flex space-x-4">
            <a href="#courses" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-indigo-50">
                Explore Courses
            </a>
            <?php if(!isLoggedIn()): ?>
                <a href="<?php echo URLROOT; ?>/users/register" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Join for Free
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="min-h-screen bg-gray-100">
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Section -->
            <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                <form hx-get="<?php echo URLROOT; ?>/courses/search" 
                      hx-trigger="change"
                      hx-target="#courses-grid"
                      hx-indicator="#search-indicator"
                      class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="keyword" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="keyword" id="keyword" 
                                   value="<?php echo $data['search']['keyword']; ?>"
                                   hx-trigger="keyup changed delay:500ms"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                   placeholder="Search courses...">
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category" 
                                    hx-trigger="change"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">All Categories</option>
                                <?php foreach($data['categories'] as $category): ?>
                                    <option value="<?php echo $category->id; ?>" 
                                            <?php echo $data['search']['category'] == $category->id ? 'selected' : ''; ?>>
                                        <?php echo $category->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="price_range" class="block text-sm font-medium text-gray-700">Price Range</label>
                            <div class="mt-1 flex space-x-2">
                                <input type="number" name="price_min" id="price_min" 
                                       value="<?php echo $data['search']['price_min']; ?>"
                                       hx-trigger="change"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="Min">
                                <input type="number" name="price_max" id="price_max" 
                                       value="<?php echo $data['search']['price_max']; ?>"
                                       hx-trigger="change"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                       placeholder="Max">
                            </div>
                        </div>
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Minimum Rating</label>
                            <select name="rating" id="rating" 
                                    hx-trigger="change"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Any Rating</option>
                                <?php for($i = 4; $i >= 1; $i--): ?>
                                    <option value="<?php echo $i; ?>" 
                                            <?php echo $data['search']['rating'] == $i ? 'selected' : ''; ?>>
                                        <?php echo $i; ?>+ Stars
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Loading indicator -->
            <div id="search-indicator" class="htmx-indicator flex justify-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
            </div>

            <!-- Courses Grid -->
            <div id="courses-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php require APPROOT . '/views/courses/partials/course_cards.php'; ?>
            </div>

            <!-- Pagination -->
            <?php if($data['pagination']['total'] > 1): ?>
                <div class="mt-8 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if($data['pagination']['hasPrev']): ?>
                            <a href="<?php echo URLROOT; ?>/courses?page=<?php echo $data['pagination']['current'] - 1; ?><?php echo !empty($_GET) ? '&' . http_build_query(array_diff_key($_GET, ['page' => ''])) : ''; ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                Previous
                            </a>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $data['pagination']['total']; $i++): ?>
                            <a href="<?php echo URLROOT; ?>/courses?page=<?php echo $i; ?><?php echo !empty($_GET) ? '&' . http_build_query(array_diff_key($_GET, ['page' => ''])) : ''; ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i === $data['pagination']['current'] ? 'text-indigo-600 bg-indigo-50' : 'text-gray-700 hover:bg-gray-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if($data['pagination']['hasNext']): ?>
                            <a href="<?php echo URLROOT; ?>/courses?page=<?php echo $data['pagination']['current'] + 1; ?><?php echo !empty($_GET) ? '&' . http_build_query(array_diff_key($_GET, ['page' => ''])) : ''; ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                Next
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?> 