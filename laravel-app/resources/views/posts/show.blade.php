@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="bg-gray-100 min-h-screen">
    <!-- Cover Photo Section -->
    <div class="relative">
        <div class="h-96 bg-cover bg-center" style="background-image: url('{{ $user->background_picture_url ? asset('storage/' . $user->background_picture_url) : asset('images/default-cover.jpg') }}');">
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="container mx-auto px-4">
            <div class="relative">
                <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                     alt="{{ $user->name }}" 
                     class="absolute -bottom-16 left-4 w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover">
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 pt-20 pb-6">
        <div class="flex flex-col md:flex-row justify-between items-start">
            <div class="mb-4 md:mb-0">
                <h1 class="text-3xl font-bold mb-2">{{ $user->name }}</h1>
                <p class="text-gray-600 mb-2">{{ $user->bio ?? 'No bio available' }}</p>
                <p class="text-gray-600">{{ $user->friends_count ?? 0 }} Friends</p>
            </div>
            <div class="flex space-x-2">
                @if (Auth::id() === $user->id)
                    <a href="{{ route('profile.edit', $user) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                @else
                    <a href="{{ route('profile.show', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <i class="fas fa-user mr-2"></i>View Profile
                    </a>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                        <i class="fas fa-user-plus mr-2"></i>Add Friend
                    </button>
                    <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                        <i class="fas fa-comment mr-2"></i>Message
                    </button>
                @endif
            </div>
        </div>

        <div class="mt-6 border-t border-gray-300 pt-6">
            <div class="flex flex-col md:flex-row">
                <!-- Left Sidebar -->
                <div class="w-full md:w-1/3 md:pr-4">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Intro</h2>
                        <ul class="space-y-3">
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-home mr-2 text-gray-500 w-5"></i>
                                Lives in <span class="font-semibold ml-1">{{ $user->location ?? 'Not specified' }}</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-briefcase mr-2 text-gray-500 w-5"></i>
                                Works at <span class="font-semibold ml-1">{{ $user->workplace ?? 'Not specified' }}</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-graduation-cap mr-2 text-gray-500 w-5"></i>
                                Studied at <span class="font-semibold ml-1">{{ $user->education ?? 'Not specified' }}</span>
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-heart mr-2 text-gray-500 w-5"></i>
                                {{ $user->relationship_status ?? 'Relationship status not specified' }}
                            </li>
                        </ul>
                        @if (Auth::id() === $user->id)
                            <button class="mt-4 w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                                Edit Details
                            </button>
                        @endif
                    </div>

                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Photos</h2>
                        <div class="grid grid-cols-3 gap-2">
                            @for ($i = 1; $i <= 9; $i++)
                                <img src="https://picsum.photos/100/100?random={{ $i }}" alt="Photo {{ $i }}" class="w-full h-24 object-cover rounded">
                            @endfor
                        </div>
                        <a href="#" class="block mt-4 text-blue-500 hover:underline">See All Photos</a>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4">Friends</h2>
                        <div class="grid grid-cols-3 gap-2">
                            @for ($i = 1; $i <= 9; $i++)
                                <div class="text-center">
                                    <img src="https://picsum.photos/100/100?random={{ $i + 10 }}" alt="Friend {{ $i }}" class="w-full h-24 object-cover rounded mb-1">
                                    <p class="text-sm truncate">Friend {{ $i }}</p>
                                </div>
                            @endfor
                        </div>
                        <a href="#" class="block mt-4 text-blue-500 hover:underline">See All Friends</a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full md:w-2/3 md:pl-4">
                    @if (Auth::id() === $user->id)
                        <!-- Create Post Section -->
                        <div class="bg-white rounded-lg shadow mb-6">
                            <div class="p-4">
                                <div class="flex items-center">
                                    <img src="{{ $user->profile_picture_url ? asset('storage/' . $user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-10 h-10 rounded-full mr-4 object-cover">
                                    <div class="w-full">
                                        <form id="createPostForm" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <textarea name="content" rows="2" class="w-full p-3 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="What's on your mind, {{ $user->name }}?"></textarea>
                                            <div id="mediaPreview" class="mt-2 hidden">
                                                <!-- Preview content will be inserted here -->
                                            </div>
                                            <div class="flex justify-between items-center mt-3">
                                                <label class="flex items-center cursor-pointer text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md">
                                                    <i class="fas fa-image mr-2 text-green-500"></i>
                                                    <span>Photo/Video</span>
                                                    <input type="file" name="media" id="mediaInput" class="hidden" accept="image/*,video/*">
                                                </label>
                                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                                    <i class="fas fa-paper-plane mr-2"></i>Post
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Posts -->
                    <div class="space-y-6">
                        @forelse($user->allPosts()->get() as $post)
                            <div class="post bg-white rounded-lg shadow" data-post-id="{{ $post->id }}">
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <img src="{{ $post->user->profile_picture_url ? asset('storage/' . $post->user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                                 alt="{{ $post->user->name }}" 
                                                 class="w-10 h-10 rounded-full mr-3 object-cover">
                                            <div>
                                                <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                                <p class="text-xs text-gray-500">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $post->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="relative">
                                            <button class="text-gray-400 hover:text-gray-600 post-options-toggle">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden post-options-menu">
                                                <div class="py-1">
                                                    @if(Auth::id() == $post->user_id)
                                                        <button class="delete-post block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Delete Post</button>
                                                    @endif
                                                    <!-- Add other options here if needed -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-800 mb-4">{{ $post->content }}</p>
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg mb-4">
                                    @endif
                                    @if($post->video)
                                        <video controls class="w-full rounded-lg mb-4">
                                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                    @if($post->original_post_id)
                                        <div class="mt-4 p-4 border rounded-lg">
                                            <p class="text-sm text-gray-500 mb-2">Shared post:</p>
                                            <div class="flex items-center mb-2">
                                                <img src="{{ $post->originalPost->user->profile_picture_url ? asset('storage/' . $post->originalPost->user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                                     alt="{{ $post->originalPost->user->name }}" 
                                                     class="w-8 h-8 rounded-full mr-2 object-cover">
                                                <div>
                                                    <h4 class="font-semibold text-sm">{{ $post->originalPost->user->name }}</h4>
                                                    <p class="text-xs text-gray-500">{{ $post->originalPost->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <p class="text-gray-800">{{ $post->originalPost->content }}</p>
                                        </div>
                                    @endif
                                    <div class="flex items-center justify-between text-gray-500 border-t border-b py-2">
                                        <div class="relative group flex-1">
                                            <button class="reaction-button flex items-center hover:bg-gray-100 px-3 py-1 rounded-md transition duration-200 w-full justify-center">
                                                <i class="far fa-thumbs-up mr-2"></i>
                                                <span class="reaction-text">Like</span>
                                            </button>
                                            <div class="reaction-options absolute bottom-full left-0 mb-2 hidden bg-white rounded-full shadow-lg p-1 flex space-x-1">
                                                <button class="reaction-btn hover:scale-125 transition-transform" data-reaction="like" title="Like">👍</button>
                                                <button class="reaction-btn hover:scale-125 transition-transform" data-reaction="love" title="Love">❤️</button>
                                                <button class="reaction-btn hover:scale-125 transition-transform" data-reaction="haha" title="Haha">😆</button>
                                                <button class="reaction-btn hover:scale-125 transition-transform" data-reaction="wow" title="Wow">😮</button>
                                                <button class="reaction-btn hover:scale-125 transition-transform" data-reaction="sad" title="Sad">😢</button>
                                                <button class="reaction-btn hover:scale-125 transition-transform" data-reaction="angry" title="Angry">😠</button>
                                            </div>
                                        </div>
                                        <button class="comment-toggle-button flex items-center hover:bg-gray-100 px-3 py-1 rounded-md transition duration-200 flex-1 justify-center">
                                            <i class="far fa-comment mr-2"></i>
                                            <span>Comment</span>
                                        </button>
                                        <button class="share-button flex items-center hover:bg-gray-100 px-3 py-1 rounded-md transition duration-200 flex-1 justify-center">
                                            <i class="far fa-share-square mr-2"></i>
                                            <span>Share</span>
                                        </button>
                                    </div>
                                    <!-- Reactions count -->
                                    <div class="flex items-center mt-2 text-sm text-gray-500 reactions-count">
                                        <div class="flex -space-x-1 mr-2">
                                            @foreach($post->top_reactions as $reaction)
                                                <span class="inline-block rounded-full text-sm">{{ $reaction }}</span>
                                            @endforeach
                                        </div>
                                        <span>{{ $post->reactions_count }} {{ Str::plural('reaction', $post->reactions_count) }}</span>
                                        <span class="ml-4 share-count">{{ $post->shares()->count() }} {{ Str::plural('share', $post->shares()->count()) }}</span>
                                    </div>
                                    <!-- Comments section -->
                                    <div class="mt-4 comments-section hidden">
                                        @foreach($post->comments as $comment)
                                            <div class="comment flex items-start mb-3" data-comment-id="{{ $comment->id }}">
                                                <img src="{{ $comment->user->profile_picture_url ? asset('storage/' . $comment->user->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                                     alt="{{ $comment->user->name }}" 
                                                     class="w-8 h-8 rounded-full mr-2 object-cover">
                                                <div class="flex-grow">
                                                    <div class="bg-gray-100 p-2 rounded-2xl">
                                                        <h4 class="font-semibold text-sm">{{ $comment->user->name }}</h4>
                                                        <p class="text-sm comment-content">{{ $comment->content }}</p>
                                                    </div>
                                                    <div class="mt-1 text-xs text-gray-500 flex items-center">
                                                        <button class="reply-comment mr-2 hover:underline">Reply</button>
                                                        @if(Auth::id() == $comment->user_id)
                                                            <button class="edit-comment mr-2 hover:underline">Edit</button>
                                                            <button class="delete-comment hover:underline">Delete</button>
                                                        @endif
                                                        <span class="text-xs text-gray-400 ml-auto">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <form class="reply-form mt-2 hidden">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <div class="flex items-center">
                                                            <input type="text" name="content" class="flex-grow p-2 border rounded-l-full" placeholder="Write a reply...">
                                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-full">Send</button>
                                                        </div>
                                                    </form>
                                                    <form class="edit-form hidden" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="text" name="content" value="{{ $comment->content }}">
                                                        <button type="submit">Update</button>
                                                    </form>
                                                    <form class="delete-form hidden">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline">Confirm Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Comment form -->
                                    <form class="comment-form mt-4">
                                        @csrf
                                        <div class="flex items-center">
                                            <img src="{{ auth()->user()->profile_picture_url ? asset('storage/' . auth()->user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                                 alt="{{ auth()->user()->name }}" 
                                                 class="w-8 h-8 rounded-full mr-2 object-cover">
                                            <div class="relative w-full">
                                                <input type="text" name="content" class="w-full p-2 pr-10 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Write a comment...">
                                                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-600">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-lg shadow p-6 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500 italic">No posts available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div id="shareModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Share Post</h3>
            <button id="closeShareModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="shareForm">
            @csrf
            <textarea name="content" class="w-full p-2 border rounded mb-4" rows="3" placeholder="Write a caption (optional)"></textarea>
            <div class="bg-gray-100 p-4 rounded mb-4">
                <div class="flex items-center mb-2">
                    <img id="shareOriginalUserImg" src="" alt="" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <h4 id="shareOriginalUserName" class="font-semibold"></h4>
                    </div>
                </div>
                <p id="shareOriginalContent" class="text-gray-700"></p>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Share</button>
        </form>
    </div>
</div>

<!-- Media Preview Modal -->
<div id="mediaPreviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Media Preview</h3>
            <button id="closeMediaPreviewModal" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="mediaPreviewContainer" class="mb-4">
            <!-- Preview content will be inserted here -->
        </div>
        <div class="flex justify-end">
            <button id="confirmMediaUpload" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mr-2">Confirm</button>
            <button id="cancelMediaUpload" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Cancel</button>
        </div>
    </div>
</div>

@endsection


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reaction handling
    document.querySelectorAll('.reaction-button').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const reactionOptions = this.nextElementSibling;
            reactionOptions.classList.toggle('hidden');
        });
    });

    document.querySelectorAll('.reaction-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.closest('.post').dataset.postId;
            const reaction = this.dataset.reaction;
            const reactionButton = this.closest('.group').querySelector('.reaction-button');
            const reactionText = reactionButton.querySelector('.reaction-text');
            
            handleReaction(postId, reaction, reactionButton, reactionText);
            
            // Hide reaction options after selection
            this.closest('.reaction-options').classList.add('hidden');
        });
    });

    // Close reaction options when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.reaction-button') && !e.target.closest('.reaction-options')) {
            document.querySelectorAll('.reaction-options').forEach(options => {
                options.classList.add('hidden');
            });
        }
    });

    // Comment toggling
    document.querySelectorAll('.comment-toggle-button').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.closest('.post').dataset.postId;
            toggleComments(postId);
        });
    });

    // Comment submission
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const postId = this.closest('.post').dataset.postId;
            submitComment(postId, this);
        });
    });

    // Share functionality
    document.querySelectorAll('.share-button').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.closest('.post').dataset.postId;
            openShareModal(postId);
        });
    });

    document.getElementById('closeShareModal').addEventListener('click', closeShareModal);

    document.getElementById('shareForm').addEventListener('submit', function(e) {
        e.preventDefault();
        submitShare(this);
    });

    // Media preview functionality
    const mediaInput = document.getElementById('mediaInput');
    const mediaPreview = document.getElementById('mediaPreview');
    const createPostForm = document.getElementById('createPostForm');
    const mediaPreviewModal = document.getElementById('mediaPreviewModal');
    const mediaPreviewContainer = document.getElementById('mediaPreviewContainer');
    const confirmMediaUploadBtn = document.getElementById('confirmMediaUpload');
    const cancelMediaUploadBtn = document.getElementById('cancelMediaUpload');
    const closeMediaPreviewModalBtn = document.getElementById('closeMediaPreviewModal');

    if (mediaInput) {
        mediaInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let previewContent;
                    if (file.type.startsWith('image/')) {
                        previewContent = `<img src="${e.target.result}" alt="Preview" class="max-w-full max-h-64 object-contain rounded-lg">`;
                    } else if (file.type.startsWith('video/')) {
                        previewContent = `<video src="${e.target.result}" controls class="max-w-full max-h-64 rounded-lg"></video>`;
                    }
                    mediaPreviewContainer.innerHTML = previewContent;
                    mediaPreviewModal.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    }

    if (confirmMediaUploadBtn) {
        confirmMediaUploadBtn.addEventListener('click', function() {
            const previewContent = mediaPreviewContainer.innerHTML;
            mediaPreview.innerHTML = previewContent;
            mediaPreview.classList.remove('hidden');
            closeMediaPreviewModal();
        });
    }

    if (cancelMediaUploadBtn) {
        cancelMediaUploadBtn.addEventListener('click', function() {
            mediaInput.value = '';
            closeMediaPreviewModal();
        });
    }

    if (closeMediaPreviewModalBtn) {
        closeMediaPreviewModalBtn.addEventListener('click', closeMediaPreviewModal);
    }

    function closeMediaPreviewModal() {
        mediaPreviewModal.classList.add('hidden');
        mediaPreviewContainer.innerHTML = '';
    }

    if (createPostForm) {
        createPostForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // You can add additional logic here if needed before submitting the form
            this.submit();
        });
    }

    // Post options menu toggle
    document.querySelectorAll('.post-options-toggle').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.nextElementSibling;
            menu.classList.toggle('hidden');
        });
    });

    // Close post options menu when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.post-options-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // Delete post functionality
    document.querySelectorAll('.delete-post').forEach(btn => {
        btn.addEventListener('click', function() {
            const postId = this.closest('.post').dataset.postId;
            deletePost(postId);
        });
    });

    // Add event delegation for reply, edit, and delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('reply-comment')) {
            handleReplyComment(e.target);
        } else if (e.target.classList.contains('edit-comment')) {
            handleEditComment(e.target);
        } else if (e.target.classList.contains('delete-comment')) {
            handleDeleteComment(e.target);
        }
    });

    // Add this new event listener for form submissions
    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('edit-form')) {
            e.preventDefault();
            submitEditForm(e.target);
        } else if (e.target.classList.contains('reply-form')) {
            e.preventDefault();
            submitReplyForm(e.target);
        }
    });
});

function handleReaction(postId, reaction, reactionButton, reactionText) {
    fetch(`/posts/${postId}/react`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ reaction: reaction })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateReactionUI(postId, data.reactionsCount, data.topReactions);
            updateReactionButton(reactionButton, reactionText, data.userReaction);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateReactionUI(postId, reactionsCount, topReactions) {
    const post = document.querySelector(`[data-post-id="${postId}"]`);
    const reactionsCountElement = post.querySelector('.reactions-count');
    reactionsCountElement.innerHTML = `
        <div class="flex -space-x-1 mr-2">
            ${topReactions.map(reaction => `<span class="inline-block rounded-full text-sm">${reaction}</span>`).join('')}
        </div>
        <span>${reactionsCount} ${reactionsCount === 1 ? 'reaction' : 'reactions'}</span>
    `;
}

function updateReactionButton(reactionButton, reactionText, reaction) {
    const reactionIcons = {
        'like': '👍',
        'love': '❤️',
        'haha': '😆',
        'wow': '😮',
        'sad': '😢',
        'angry': '😠'
    };

    if (reaction) {
        reactionButton.innerHTML = `
            <span class="mr-2">${reactionIcons[reaction]}</span>
            <span class="reaction-text">${reaction.charAt(0).toUpperCase() + reaction.slice(1)}</span>
        `;
        reactionButton.classList.add('text-blue-500');
    } else {
        reactionButton.innerHTML = `
            <i class="far fa-thumbs-up mr-2"></i>
            <span class="reaction-text">Like</span>
        `;
        reactionButton.classList.remove('text-blue-500');
    }
}

function toggleComments(postId) {
    const post = document.querySelector(`[data-post-id="${postId}"]`);
    const commentsSection = post.querySelector('.comments-section');
    commentsSection.classList.toggle('hidden');
}

function submitComment(postId, form) {
    const formData = new FormData(form);
    fetch(`/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addCommentToUI(postId, data.comment);
            form.reset();
        }
    })
    .catch(error => console.error('Error:', error));
}

function addCommentToUI(postId, comment) {
    const post = document.querySelector(`[data-post-id="${postId}"]`);
    const commentsSection = post.querySelector('.comments-section');
    
    // Helper function to get the full URL for an asset
    const getAssetUrl = (path) => {
        const baseUrl = window.location.origin;
        return path.startsWith('http') ? path : `${baseUrl}/storage/${path}`;
    };

    const profilePicUrl = comment.user.profile_picture_url
        ? getAssetUrl(comment.user.profile_picture_url)
        : getAssetUrl('images/default-avatar.jpg');

    const commentHTML = `
        <div class="comment flex items-start mb-3" data-comment-id="${comment.id}">
            <img src="${profilePicUrl}" 
                 alt="${comment.user.name}" 
                 class="w-8 h-8 rounded-full mr-2 object-cover">
            <div class="flex-grow">
                <div class="bg-gray-100 p-2 rounded-2xl">
                    <h4 class="font-semibold text-sm">${comment.user.name}</h4>
                    <p class="text-sm comment-content">${comment.content}</p>
                </div>
                <div class="mt-1 text-xs text-gray-500 flex items-center">
                    <button class="reply-comment mr-2 hover:underline">Reply</button>
                    <button class="edit-comment mr-2 hover:underline">Edit</button>
                    <button class="delete-comment hover:underline">Delete</button>
                    <span class="text-xs text-gray-400 ml-auto">Just now</span>
                </div>
            </div>
        </div>
    `;
    commentsSection.insertAdjacentHTML('beforeend', commentHTML);
}

function openShareModal(postId) {
    const modal = document.getElementById('shareModal');
    modal.classList.remove('hidden');
    modal.dataset.postId = postId;

    const post = document.querySelector(`[data-post-id="${postId}"]`);
    const userImg = post.querySelector('img').src;
    const userName = post.querySelector('h3').textContent;
    const postContent = post.querySelector('p').textContent;

    document.getElementById('shareOriginalUserImg').src = userImg;
    document.getElementById('shareOriginalUserName').textContent = userName;
    document.getElementById('shareOriginalContent').textContent = postContent;
}

function closeShareModal() {
    const modal = document.getElementById('shareModal');
    modal.classList.add('hidden');
}

function submitShare(form) {
    const postId = document.getElementById('shareModal').dataset.postId;
    const formData = new FormData(form);
    fetch(`/posts/${postId}/share`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeShareModal();
            updateShareCount(postId);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateShareCount(postId) {
    const post = document.querySelector(`[data-post-id="${postId}"]`);
    const shareCountElement = post.querySelector('.share-count');
    const currentCount = parseInt(shareCountElement.textContent.split(' ')[0]);
    shareCountElement.textContent = `${currentCount + 1} ${currentCount + 1 === 1 ? 'share' : 'shares'}`;
}

function deletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        fetch(`/posts/${postId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const post = document.querySelector(`[data-post-id="${postId}"]`);
                post.remove();
            } else {
                alert('Failed to delete post: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the post. Please try again.');
        });
    }
}

function handleReplyComment(button) {
    const commentDiv = button.closest('.comment');
    const replyForm = commentDiv.querySelector('.reply-form');
    replyForm.classList.toggle('hidden');
}

function handleEditComment(button) {
    const commentDiv = button.closest('.comment');
    const commentContent = commentDiv.querySelector('.comment-content');
    const editForm = commentDiv.querySelector('.edit-form');
    const editInput = editForm.querySelector('input[name="content"]');

    if (editForm.classList.contains('hidden')) {
        editInput.value = commentContent.textContent.trim();
        commentContent.classList.add('hidden');
        editForm.classList.remove('hidden');
    } else {
        commentContent.classList.remove('hidden');
        editForm.classList.add('hidden');
    }
}

function handleDeleteComment(button) {
    if (confirm('Are you sure you want to delete this comment?')) {
        const commentDiv = button.closest('.comment');
        const commentId = commentDiv.dataset.commentId;
        
        fetch(`/comments/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                commentDiv.remove();
            } else {
                alert('Failed to delete comment: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function submitReplyForm(form) {
    const formData = new FormData(form);
    const postId = form.closest('.post').dataset.postId;
    const parentCommentId = form.querySelector('input[name="parent_id"]').value;

    fetch(`/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addCommentToUI(postId, data.comment, form.closest('.comment'));
            form.reset();
            form.classList.add('hidden');
        } else {
            alert('Failed to post reply: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function submitEditForm(form) {
    const commentDiv = form.closest('.comment');
    if (!commentDiv) {
        console.error('Could not find parent comment div');
        return;
    }
    const commentId = commentDiv.dataset.commentId;
    if (!commentId) {
        console.error('Could not find comment ID');
        return;
    }

    const contentInput = form.querySelector('input[name="content"]');
    if (!contentInput || !contentInput.value.trim()) {
        alert('Comment content cannot be empty');
        return;
    }

    const formData = new FormData(form);

    fetch(`/comments/${commentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            content: contentInput.value,
            _method: 'PATCH'  // This line is important for method spoofing
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentContent = commentDiv.querySelector('.comment-content');
            if (commentContent) {
                commentContent.textContent = data.comment.content;
                commentContent.classList.remove('hidden');
            } else {
                console.error('Could not find comment content element');
            }
            form.classList.add('hidden');
        } else {
            alert('Failed to update comment: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the comment. Please try again.');
    });
}

// Event listeners for form submissions
document.addEventListener('submit', function(e) {
    if (e.target.classList.contains('edit-form')) {
        e.preventDefault();
        submitEditForm(e.target);
    } else if (e.target.classList.contains('reply-form')) {
        e.preventDefault();
        submitReplyForm(e.target);
    }
});
</script>