@extends('layouts.app')
@section('title', 'Create Post')
@section('content')
    @push('style')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .ck-editor__editable_inline {
                min-height: 300px;
            }

            .select2-container .select2-selection--multiple {
                min-height: 38px;
                border-color: #d1d5db;
                border-radius: 0.375rem;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #3b82f6;
                color: white;
                border: none;
                border-radius: 0.25rem;
                padding: 2px 8px;
                margin-top: 4px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
                color: white;
                margin-right: 5px;
            }

            .select2-dropdown {
                border-color: #d1d5db;
                border-radius: 0.375rem;
            }
        </style>
    @endpush

    <div class="container mx-auto p-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Create New Post</h1>
                <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Posts
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-md mb-6 border border-red-200">
                    <div class="font-medium">Oops! There were some problems with your input:</div>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title and Slug -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Enter post title">
                    </div>
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="your-post-slug">
                        <p class="text-xs text-gray-500 mt-1">URL-friendly version of the title (auto-generated, but can be
                            edited)</p>
                    </div>
                </div>

                <!-- Subtitle -->
                <div>
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="A brief description of your post">
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span
                            class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select a category</option>
                        @foreach (\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                    <select name="tags[]" id="tags" multiple
                        class="tags-select w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach (\App\Models\Tag::all() as $tag)
                            <option value="{{ $tag->id }}"
                                {{ old('tags') && in_array($tag->id, old('tags')) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Select existing tags or type to create new ones</p>
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <img id="image-preview" src="/placeholder.svg?height=150&width=250" alt="Featured image preview"
                                class="w-64 h-40 object-cover rounded-md border border-gray-300">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity rounded-md">
                                <span class="text-white text-sm">Preview</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="featured_image" id="featured_image" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                onchange="previewImage(event)">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 1200×800 pixels, max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                    <div class="relative">
                        <textarea name="content" id="content" rows="10"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Write your post content here...">{{ old('content') }}</textarea>

                        <div class="absolute right-4 top-4 flex space-x-2">
                            <button type="button" id="imageUploadBtn"
                                class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>

                        <input type="file" id="imageInput" class="hidden" accept="image/*" multiple>
                    </div>

                    <div id="imagePreviewContainer" class="mt-4 flex flex-wrap gap-4"></div>

                    <div class="mt-2 text-sm text-gray-500">
                        <p>Click the image icon to upload images, or drag and drop them directly into the editor.
                            Images will be inserted at the cursor position.</p>
                    </div>
                </div>

                <!-- Publishing Options -->
                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Publishing Options</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span
                                    class="text-red-500">*</span></label>
                            <select name="status" id="status" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish
                                Date</label>
                            <input type="datetime-local" name="published_at" id="published_at"
                                value="{{ old('published_at') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Leave empty to use current date when published</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('posts.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
        <script>
            // Initialize Select2 for tags
            $(document).ready(function() {
                $('.tags-select').select2({
                    tags: true,
                    tokenSeparators: [','],
                    placeholder: 'Select or create tags',
                });
            });

            // Auto-generate slug from title
            document.getElementById('title').addEventListener('keyup', function() {
                const title = this.value;
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/--+ /g, '-') // Replace multiple hyphens with single hyphen
                    .trim(); // Trim leading/trailing spaces

                document.getElementById('slug').value = slug;
            });

            // Image preview for featured image
            function previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('image-preview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Initialize CKEditor
            let ckeditor;
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'imageUpload', 'bulletedList', 'numberedList',
                        'blockQuote',
                        'insertTable', 'undo', 'redo'
                    ],
                })
                .then(editor => {
                    ckeditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            // Handle image upload for content
            const imageUploadBtn = document.getElementById('imageUploadBtn');
            const imageInput = document.getElementById('imageInput');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            imageUploadBtn.addEventListener('click', () => {
                imageInput.click();
            });

            imageInput.addEventListener('change', () => {
                const files = imageInput.files;
                for (let file of files) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const url = e.target.result;

                        // Create preview
                        const img = document.createElement('img');
                        img.src = url;
                        img.classList.add('w-32', 'h-32', 'object-cover', 'rounded');
                        imagePreviewContainer.appendChild(img);

                        // Insert into editor at current position
                        ckeditor.model.change(writer => {
                            const imageElement = writer.createElement('imageBlock', {
                                src: url
                            });
                            ckeditor.model.insertContent(imageElement, ckeditor.model.document.selection);
                        });
                    };
                    reader.readAsDataURL(file);
                }
                // Clear the input value to allow re-uploading the same file
                imageInput.value = '';
            });
        </script>
    @endpush
@endsection
