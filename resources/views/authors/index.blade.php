@extends('layouts.app')
@section('title', 'Author Profile Settings')
@section('content')
    @push('style')
        <style>
            .file-upload-wrapper {
                position: relative;
                overflow: hidden;
                display: inline-block;
            }

            .file-upload-wrapper input[type=file] {
                position: absolute;
                left: -9999px;
            }

            .profile-avatar {
                transition: all 0.3s ease;
            }

            .profile-avatar:hover {
                transform: scale(1.05);
            }

            .settings-section {
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush

    <body class="bg-gray-50 min-h-screen">

        <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Profile Settings</h2>
                <p class="mt-2 text-gray-600">Manage your author profile and account preferences</p>
            </div>

            <form class="space-y-8" method="POST" action="{{ route('profile.update', auth()->user()) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <!-- Profile Information Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-user mr-2 text-blue-600"></i>
                        Profile Information
                    </h3>

                    <!-- Profile Picture -->
                    <div class="flex items-center space-x-6 mb-6">
                        <div class="relative">
                            <img id="profileImage"
                                src="{{ auth()->user()->profile_image_url ? asset(auth()->user()->profile_image_url) : '/placeholder.svg?height=120&width=120' }}"
                                alt="Profile Picture"
                                class="profile-avatar w-24 h-24 rounded-full object-cover border-4 border-gray-200">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                                <i class="fas fa-camera text-white text-lg"></i>
                            </div>
                        </div>
                        <div>
                            <div class="file-upload-wrapper">
                                <label for="avatar-upload"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 cursor-pointer transition-colors">
                                    Change Photo
                                </label>
                                <input id="avatar-upload" name="profile_image" type="file" accept="image/*"
                                    onchange="previewImage(event)">
                            </div>
                            <p class="text-sm text-gray-500 mt-2">JPG, PNG or GIF. Max size 2MB.</p>
                        </div>
                    </div>

                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" id="phone" name="phone" value="{{ auth()->user()->phone }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Your primary email address for notifications</p>
                    </div>

                    <div class="mt-6">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Tell readers about yourself...">{{ auth()->user()->bio }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Brief description for your author profile</p>
                    </div>
                </div>

                <!-- Account Settings Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-cog mr-2 text-blue-600"></i>
                        Account Settings
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input type="text" id="username" name="username"
                                value="{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Your unique username for your author profile URL</p>
                        </div>

                        <div class="border-t pt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Change Password</h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="currentPassword"
                                        class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" id="currentPassword" name="currentPassword"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New
                                            Password</label>
                                        <input type="password" id="newPassword" name="newPassword"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label for="confirmPassword"
                                            class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                        <input type="password" id="confirmPassword" name="confirmPassword"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-share-alt mr-2 text-blue-600"></i>
                        Social Media Links
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-twitter text-blue-400 text-xl w-6"></i>
                            <input type="url" name="twitter" placeholder="https://twitter.com/username"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                value="{{ auth()->user()->twitter_url ?? '' }}">
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-linkedin text-blue-600 text-xl w-6"></i>
                            <input type="url" name="linkedin" placeholder="https://linkedin.com/in/username"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fab fa-github text-gray-800 text-xl w-6"></i>
                            <input type="url" name="github" placeholder="https://github.com/username"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-globe text-green-600 text-xl w-6"></i>
                            <input type="url" name="website" placeholder="https://yourwebsite.com"
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Notification Preferences Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-bell mr-2 text-blue-600"></i>
                        Notification Preferences
                    </h3>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                <p class="text-sm text-gray-500">Receive email updates about your posts and comments</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Comment Notifications</h4>
                                <p class="text-sm text-gray-500">Get notified when someone comments on your posts</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Marketing Emails</h4>
                                <p class="text-sm text-gray-500">Receive updates about new features and tips</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Publishing Preferences Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-edit mr-2 text-blue-600"></i>
                        Publishing Preferences
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <label for="defaultVisibility" class="block text-sm font-medium text-gray-700 mb-2">Default
                                Post
                                Visibility</label>
                            <select id="defaultVisibility" name="defaultVisibility"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="public">Public</option>
                                <option value="unlisted">Unlisted</option>
                                <option value="private">Private</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Auto-save Drafts</h4>
                                <p class="text-sm text-gray-500">Automatically save your work as you write</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Show Author Bio</h4>
                                <p class="text-sm text-gray-500">Display your bio at the end of each post</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Author's Posts Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-green-600"></i>
                        My Posts
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th
                                        class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title</th>
                                    <th
                                        class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach (auth()->user()->posts()->latest()->paginate(5) as $post)
                                    <tr>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center">
                                                @if ($post->featured_image)
                                                    <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                        <img class="h-10 w-10 rounded-md object-cover"
                                                            src="{{ asset('storage/' . $post->featured_image) }}"
                                                            alt="{{ $post->title }}">
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $post->title }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 truncate max-w-xs">
                                                        {{ $post->subtitle }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div x-data="{
                                                status: '{{ $post->status }}',
                                                isLoading: false,
                                                async updateStatus() {
                                                    this.isLoading = true;
                                                    try {
                                                        await fetch('{{ route('posts.update-status', $post) }}', {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                            },
                                                            body: JSON.stringify({
                                                                _method: 'PATCH',
                                                                status: this.status
                                                            })
                                                        });
                                            
                                                        // Show success notification
                                                        $dispatch('notify', {
                                                            message: 'Status updated successfully',
                                                            type: 'success'
                                                        });
                                                    } catch (error) {
                                                        // Show error notification
                                                        $dispatch('notify', {
                                                            message: 'Failed to update status',
                                                            type: 'error'
                                                        });
                                                    } finally {
                                                        this.isLoading = false;
                                                    }
                                                }
                                            }" @change="updateStatus()">
                                                <select x-model="status" :disabled="isLoading"
                                                    class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="draft">Draft</option>
                                                    <option value="published">Published</option>

                                                </select>
                                                <div x-show="isLoading" class="mt-1 text-xs text-gray-500">
                                                    Updating...
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="text-sm text-gray-900">
                                                {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-sm">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('posts.edit', $post) }}"
                                                    class="text-blue-600 hover:text-blue-900">Edit</a>
                                                <a href="{{ route('posts.show', $post) }}"
                                                    class="text-green-600 hover:text-green-900">View</a>
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ auth()->user()->posts()->latest()->paginate(5)->links() }}
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('posts.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-plus mr-2"></i> Create New Post
                        </a>
                    </div>
                </div>

                <!-- Account Management Section -->
                <div class="settings-section bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-shield-alt mr-2 text-red-600"></i>
                        Account Management
                    </h3>

                    <div class="space-y-4">
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                                <h4 class="text-sm font-medium text-yellow-800">Export Your Data</h4>
                            </div>
                            <p class="text-sm text-yellow-700 mt-1">Download a copy of all your posts and data</p>
                            <button type="button"
                                class="mt-2 bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700 transition-colors">
                                Export Data
                            </button>
                        </div>

                        <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-trash-alt text-red-600 mr-2"></i>
                                <h4 class="text-sm font-medium text-red-800">Delete Account</h4>
                            </div>
                            <p class="text-sm text-red-700 mt-1">Permanently delete your account and all associated data
                            </p>
                            <button type="button"
                                class="mt-2 bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition-colors">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button"
                        class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>


        @push('script')
            <script>
                function previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('profileImage').src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                }

                // Form validation and submission
                document.querySelector('form').addEventListener('submit', function(e) {
                    // We're not preventing default since we want the form to submit to the server
                    // e.preventDefault();

                    // Basic validation
                    const requiredFields = ['firstName', 'lastName', 'email', 'username'];
                    let isValid = true;

                    requiredFields.forEach(field => {
                        const input = document.getElementById(field);
                        if (input && !input.value.trim()) {
                            input.classList.add('border-red-500');
                            isValid = false;
                        } else if (input) {
                            input.classList.remove('border-red-500');
                        }
                    });

                    // Password validation
                    const newPassword = document.getElementById('newPassword')?.value;
                    const confirmPassword = document.getElementById('confirmPassword')?.value;

                    if (newPassword && newPassword !== confirmPassword) {
                        document.getElementById('confirmPassword').classList.add('border-red-500');
                        isValid = false;
                    } else if (document.getElementById('confirmPassword')) {
                        document.getElementById('confirmPassword').classList.remove('border-red-500');
                    }

                    if (isValid) {
                        // Show success message
                        const successMessage = document.createElement('div');
                        successMessage.className =
                            'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50';
                        successMessage.textContent = 'Profile updated successfully!';
                        document.body.appendChild(successMessage);

                        setTimeout(() => {
                            successMessage.remove();
                        }, 3000);
                    }
                });

                // Toggle switches animation
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        // Add a subtle animation effect
                        this.parentElement.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.parentElement.style.transform = 'scale(1)';
                        }, 100);
                    });
                });

                // Post status change handling
                document.querySelectorAll('.status-select').forEach(select => {
                    select.addEventListener('change', function() {
                        // Show loading indicator
                        const originalText = this.options[this.selectedIndex].text;
                        this.options[this.selectedIndex].text = 'Updating...';

                        // Submit the form
                        this.form.submit();

                        // Show notification
                        const statusNotification = document.createElement('div');
                        statusNotification.className =
                            'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-md shadow-lg z-50';
                        statusNotification.textContent = 'Updating post status...';
                        document.body.appendChild(statusNotification);

                        setTimeout(() => {
                            statusNotification.remove();
                        }, 2000);
                    });
                });
            </script>
        @endpush
    @endsection
