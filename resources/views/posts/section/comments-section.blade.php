<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Comments (23)</h2>

    <!-- Comment Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h3>
        <form id="commentForm">
            <div class="mb-4">
                <textarea placeholder="Share your thoughts..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                    rows="4"></textarea>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">Notify me of replies</span>
                    </label>
                </div>
                <button type="submit"
                    class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                    Post Comment
                </button>
            </div>
        </form>
    </div>

    <!-- Comments List -->
    <div class="space-y-6">
        <!-- Comment 1 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-start space-x-4">
                <img src="/placeholder.svg?height=40&width=40" alt="Mike Chen" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <h4 class="font-semibold text-gray-900">Mike Chen</h4>
                        <span class="text-sm text-gray-500">2 hours ago</span>
                    </div>
                    <p class="text-gray-700 mb-3">
                        Great article! The Array.groupBy() method is exactly what I've been waiting for.
                        No more writing custom grouping functions. Can't wait to use this in production.
                    </p>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-purple-600 text-sm">
                            <i class="far fa-thumbs-up mr-1"></i>12
                        </button>
                        <button class="text-gray-500 hover:text-purple-600 text-sm">Reply</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comment 2 -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-start space-x-4">
                <img src="/placeholder.svg?height=40&width=40" alt="Emily Rodriguez" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <div class="flex items-center space-x-2 mb-2">
                        <h4 class="font-semibold text-gray-900">Emily Rodriguez</h4>
                        <span class="text-sm text-gray-500">4 hours ago</span>
                    </div>
                    <p class="text-gray-700 mb-3">
                        The Temporal API section was particularly helpful. I've been struggling with timezone
                        issues in my current project. Time to start experimenting with the polyfill!
                    </p>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-purple-600 text-sm">
                            <i class="far fa-thumbs-up mr-1"></i>8
                        </button>
                        <button class="text-gray-500 hover:text-purple-600 text-sm">Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load More Comments -->
    <div class="text-center mt-8">
        <button class="text-purple-600 hover:text-purple-700 font-medium">
            Load More Comments
        </button>
    </div>
</section>
