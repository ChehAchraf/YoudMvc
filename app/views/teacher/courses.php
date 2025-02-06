<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="min-h-screen bg-gray-100">
    <!-- Teacher Navigation -->
    <?php require APPROOT . '/views/inc/teacher_nav.php'; ?>

    <div class="py-10">
        <header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        My Courses
                    </h1>
                    <button onclick="showCreateModal()" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Course
                    </button>
                </div>
            </div>
        </header>

        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Message -->
                <?php flash('teacher_message'); ?>

                <!-- Courses Grid -->
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach($data['courses'] as $course): ?>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <?php if($course->thumbnail): ?>
                                <img class="h-48 w-full object-cover" src="<?php echo URLROOT . '/uploads/' . $course->thumbnail; ?>" alt="<?php echo $course->title; ?>">
                            <?php else: ?>
                                <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        <?php echo $course->title; ?>
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?php echo $course->status === 'published' ? 'bg-green-100 text-green-800' : 
                                            ($course->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : 
                                            'bg-red-100 text-red-800'); ?>">
                                        <?php echo ucfirst($course->status); ?>
                                    </span>
                                </div>

                                <p class="mt-2 text-sm text-gray-600">
                                    <?php echo strlen($course->description) > 100 ? substr($course->description, 0, 100) . '...' : $course->description; ?>
                                </p>

                                <div class="mt-4">
                                    <span class="text-sm font-medium text-gray-500">Category:</span>
                                    <span class="ml-1 text-sm text-gray-900"><?php echo $course->category_name; ?></span>
                                </div>

                                <div class="mt-2">
                                    <span class="text-sm font-medium text-gray-500">Price:</span>
                                    <span class="ml-1 text-sm text-gray-900">$<?php echo number_format($course->price, 2); ?></span>
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-500"><?php echo $course->enrollment_count ?? 0; ?> students</span>
                                        <span class="text-sm text-gray-500">•</span>
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="ml-1 text-sm text-gray-500"><?php echo number_format($course->avg_rating, 1); ?></span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="showEditModal(<?php echo htmlspecialchars(json_encode($course)); ?>)" 
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Edit
                                        </button>
                                        <a href="<?php echo URLROOT; ?>/courses/view/<?php echo $course->id; ?>" 
                                           class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Create Course Modal -->
<div id="createModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?php echo URLROOT; ?>/teacher/courses/create" method="POST" enctype="multipart/form-data" class="p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Create New Course</h3>
                
                <!-- Thumbnail Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Course Thumbnail</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <div class="flex text-sm text-gray-600">
                                <label for="thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            <div id="thumbnail-preview" class="mt-2 hidden">
                                <img src="" alt="Thumbnail preview" class="mx-auto h-32 w-auto">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Existing fields -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Select a category</option>
                        <?php foreach($data['categories'] as $category): ?>
                            <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Course Content Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Course Content</label>
                    <div class="mt-1 flex flex-col space-y-2">
                        <select name="content_type" id="content_type" required
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                onchange="toggleContentUpload()">
                            <option value="">Select content type</option>
                            <option value="video">Video</option>
                            <option value="document">Document</option>
                        </select>
                        
                        <div id="video_upload" class="hidden">
                            <label for="video_url" class="block text-sm font-medium text-gray-700">Video URL (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" id="video_url"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="https://...">
                        </div>

                        <div id="document_upload" class="hidden">
                            <label for="course_file" class="block text-sm font-medium text-gray-700">Upload Document</label>
                            <input type="file" name="course_file" id="course_file"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX, PPT, PPTX</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hideCreateModal()"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="p-6">
                <input type="hidden" name="course_id" id="edit_course_id">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Course</h3>
                
                <!-- Thumbnail Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Course Thumbnail</label>
                    <div class="mt-1">
                        <div id="current_thumbnail" class="mb-2">
                            <img src="" alt="Current thumbnail" class="h-32 w-auto">
                        </div>
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <div class="flex text-sm text-gray-600">
                                    <label for="edit_thumbnail" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload new thumbnail</span>
                                        <input id="edit_thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="mb-4">
                    <label for="edit_title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="edit_title" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="edit_description" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="mb-4">
                    <label for="edit_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="edit_category_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <?php foreach($data['categories'] as $category): ?>
                            <option value="<?php echo $category->id; ?>"><?php echo $category->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Course Content -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Course Content</label>
                    <div class="mt-1 flex flex-col space-y-2">
                        <select name="content_type" id="edit_content_type" required
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                onchange="toggleEditContentUpload()">
                            <option value="video">Video</option>
                            <option value="document">Document</option>
                        </select>
                        
                        <div id="edit_video_upload">
                            <label for="edit_video_url" class="block text-sm font-medium text-gray-700">Video URL (YouTube/Vimeo)</label>
                            <input type="url" name="video_url" id="edit_video_url"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                   placeholder="https://...">
                        </div>

                        <div id="edit_document_upload" class="hidden">
                            <div id="current_document" class="mb-2 text-sm text-gray-600"></div>
                            <label for="edit_course_file" class="block text-sm font-medium text-gray-700">Upload New Document</label>
                            <input type="file" name="course_file" id="edit_course_file"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx">
                            <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX, PPT, PPTX</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="edit_price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                    <input type="number" name="price" id="edit_price" step="0.01" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hideEditModal()"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
}

function hideCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
}

function toggleContentUpload() {
    const contentType = document.getElementById('content_type').value;
    const videoUpload = document.getElementById('video_upload');
    const documentUpload = document.getElementById('document_upload');

    videoUpload.classList.add('hidden');
    documentUpload.classList.add('hidden');

    if (contentType === 'video') {
        videoUpload.classList.remove('hidden');
        document.getElementById('video_url').required = true;
        document.getElementById('course_file').required = false;
    } else if (contentType === 'document') {
        documentUpload.classList.remove('hidden');
        document.getElementById('course_file').required = true;
        document.getElementById('video_url').required = false;
    }
}

// Thumbnail preview
document.getElementById('thumbnail').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        const preview = document.getElementById('thumbnail-preview');
        const previewImage = preview.querySelector('img');

        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(file);
    }
});

// Drag and drop functionality for thumbnail
const thumbnailDropzone = document.querySelector('label[for="thumbnail"]').parentElement;
thumbnailDropzone.addEventListener('dragover', e => {
    e.preventDefault();
    thumbnailDropzone.classList.add('border-indigo-500');
});

thumbnailDropzone.addEventListener('dragleave', e => {
    e.preventDefault();
    thumbnailDropzone.classList.remove('border-indigo-500');
});

thumbnailDropzone.addEventListener('drop', e => {
    e.preventDefault();
    thumbnailDropzone.classList.remove('border-indigo-500');
    
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        const input = document.getElementById('thumbnail');
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    }
});

function toggleEditContentUpload() {
    const contentType = document.getElementById('edit_content_type').value;
    const videoUpload = document.getElementById('edit_video_upload');
    const documentUpload = document.getElementById('edit_document_upload');

    if (contentType === 'video') {
        videoUpload.classList.remove('hidden');
        documentUpload.classList.add('hidden');
        document.getElementById('edit_video_url').required = true;
        document.getElementById('edit_course_file').required = false;
    } else {
        documentUpload.classList.remove('hidden');
        videoUpload.classList.add('hidden');
        document.getElementById('edit_course_file').required = false;
        document.getElementById('edit_video_url').required = false;
    }
}

function showEditModal(course) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    // Set form action
    form.action = `<?php echo URLROOT; ?>/teacher/courses/edit/${course.id}`;
    
    // Populate form fields
    document.getElementById('edit_course_id').value = course.id;
    document.getElementById('edit_title').value = course.title;
    document.getElementById('edit_description').value = course.description;
    document.getElementById('edit_category_id').value = course.category_id;
    document.getElementById('edit_price').value = course.price;
    
    // Set content type and show appropriate fields
    document.getElementById('edit_content_type').value = course.content_type || 'video';
    if (course.content_type === 'video') {
        document.getElementById('edit_video_url').value = course.content_url || '';
    }
    
    // Show current thumbnail if exists
    const thumbnailContainer = document.getElementById('current_thumbnail');
    if (course.thumbnail) {
        thumbnailContainer.querySelector('img').src = `<?php echo URLROOT; ?>/uploads/${course.thumbnail}`;
        thumbnailContainer.classList.remove('hidden');
    } else {
        thumbnailContainer.classList.add('hidden');
    }
    
    // Show current document if exists
    const documentInfo = document.getElementById('current_document');
    if (course.file_path) {
        documentInfo.textContent = `Current file: ${course.file_path.split('/').pop()}`;
        documentInfo.classList.remove('hidden');
    } else {
        documentInfo.classList.add('hidden');
    }
    
    toggleEditContentUpload();
    modal.classList.remove('hidden');
}

function hideEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?> 