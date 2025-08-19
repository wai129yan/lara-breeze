<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <h3 class="text-lg font-semibold mt-4">Followed Authors</h3>
                    <ul class="list-disc pl-5">
                        @foreach (auth()->user()->following as $followed)
                            <li class="flex items-center justify-between">
                                {{ $followed->name }}
                                <div class="flex items-center space-x-2">
                                    <span>(Followers: {{ $followed->followers_count }})</span>
                                    <button class="bg-purple-600 text-white px-2 py-1 rounded hover:bg-purple-700"
                                        data-user-id="{{ $followed->id }}" data-is-following="true"
                                        onclick="handleFollowToggle(this)">
                                        Unfollow
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function handleFollowToggle(button) {
                const userId = button.dataset.userId;
                const isFollowing = button.dataset.isFollowing === 'true';
                const csrfToken = '{{ csrf_token() }}';

                fetch('/follow/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            followed_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        button.dataset.isFollowing = data.is_following;
                        button.textContent = data.is_following ? 'Unfollow' : 'Follow';
                        // Optionally, remove the list item if unfollowed
                        if (!data.is_following) {
                            button.closest('li').remove();
                        }
                        showToast(data.message);
                    })
                    .catch(error => {
                        console.error('Error toggling follow:', error);
                        showToast('Failed to update follow status', 'error');
                    });
            }

            function showToast(message, type = 'info') {
                // Similar toast function as in post view
                const toast = document.createElement('div');
                const bgColor = type === 'error' ? 'bg-red-500' : 'bg-gray-900';
                toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
                toast.textContent = message;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        </script>
    @endpush
</x-app-layout>
