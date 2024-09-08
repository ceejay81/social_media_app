<!-- resources/views/home/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Create Post Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-2xl font-semibold mb-4">Create a Post</h2>
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center mb-4">
                        <img src="{{ auth()->user()->profile_picture_url ? asset('storage/' . auth()->user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="w-10 h-10 rounded-full mr-4 object-cover">
                        <textarea name="content" rows="3" class="w-full p-2 border rounded-md" placeholder="What's on your mind, {{ auth()->user()->name }}?"></textarea>
                    </div>
                    <div class="flex justify-between items-center">
                        <input type="file" name="image" class="text-sm" accept="image/*">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Post</button>
                    </div>
                </form>
            </div>

            <!-- Posts Feed -->
            <div class="space-y-6">
                @forelse($posts as $post)
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center mb-4">
                            <img src="{{ $post->user->profile_picture_url ? asset('storage/' . $post->user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                 alt="{{ $post->user->name }}" 
                                 class="w-10 h-10 rounded-full mr-4 object-cover">
                            <div>
                                <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-gray-800 mb-4">{{ $post->content }}</p>
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg mb-4">
                        @endif
                        <div class="flex items-center space-x-4 mb-4">
                            <button class="like-button flex items-center text-gray-500 hover:text-blue-500" data-post-id="{{ $post->id }}">
                                <i class="far fa-thumbs-up mr-1"></i>
                                <span class="likes-count">{{ $post->likes_count }}</span> Like
                            </button>
                            <button class="comment-toggle flex items-center text-gray-500 hover:text-blue-500" data-post-id="{{ $post->id }}">
                                <i class="far fa-comment mr-1"></i>
                                <span>{{ $post->comments_count }}</span> Comments
                            </button>
                            <button class="share-button flex items-center text-gray-500 hover:text-blue-500">
                                <i class="far fa-share-square mr-1"></i> Share
                            </button>
                        </div>
                        <div id="comments-{{ $post->id }}" class="mt-4 hidden">
                            <!-- Comments will be loaded here -->
                        </div>
                        <form class="comment-form mt-4" action="{{ route('comments.store', $post->id) }}" method="POST" data-post-id="{{ $post->id }}">
                            @csrf
                            <div class="flex items-center">
                                <img src="{{ auth()->user()->profile_picture_url ? asset('storage/' . auth()->user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-8 h-8 rounded-full mr-2 object-cover">
                                <textarea name="content" rows="1" class="w-full p-2 border rounded-md" placeholder="Write a comment..."></textarea>
                            </div>
                            <div class="text-right mt-2">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">Comment</button>
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500 italic">No posts available</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Existing like and comment toggle functionality...

        // Real-time updates
        window.Echo.channel('posts')
            .listen('NewLike', (e) => {
                const likeButton = document.querySelector(`.like-button[data-post-id="${e.postId}"]`);
                if (likeButton) {
                    likeButton.querySelector('.likes-count').textContent = e.likesCount;
                }
            })
            .listen('NewComment', (e) => {
                const commentsSection = document.querySelector(`#comments-${e.comment.post_id}`);
                if (commentsSection) {
                    const newComment = document.createElement('div');
                    newComment.className = 'bg-gray-50 p-3 rounded mb-2';
                    newComment.innerHTML = `
                        <p class="font-semibold">${e.comment.user.name}</p>
                        <p>${e.comment.content}</p>
                        <p class="text-xs text-gray-500">${moment(e.comment.created_at).fromNow()}</p>
                    `;
                    commentsSection.insertBefore(newComment, commentsSection.firstChild);

                    // Update comment count
                    const commentToggle = document.querySelector(`.comment-toggle[data-post-id="${e.comment.post_id}"]`);
                    const currentCount = parseInt(commentToggle.textContent.match(/\d+/)[0]);
                    commentToggle.textContent = commentToggle.textContent.replace(/\d+/, currentCount + 1);
                }
            });

        // AJAX for comment submission
        document.querySelectorAll('.comment-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const postId = this.dataset.postId;
                const content = this.querySelector('textarea[name="content"]').value;
                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.reset();
                        // Add new comment to the DOM (similar to the NewComment event listener)
                    }
                });
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    @media (min-width: 768px) {
        .sticky-sidebar {
            position: sticky;
            top: 20px; /* Adjust this value as needed */
            height: calc(100vh - 40px); /* Adjust this value as needed */
            overflow-y: auto;
        }
    }
</style>
@endsection
