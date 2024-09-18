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
                <p class="text-gray-600">{{ $user->friends_count ?? 0 }} Friends</p>
            </div>
            <div class="flex space-x-2">
                @if (Auth::id() === $user->id)
                    <a href="{{ route('profile.edit', $user) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </a>
                @else
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
                                        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <textarea name="content" rows="2" class="w-full p-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="What's on your mind, {{ $user->name }}?"></textarea>
                                            <div class="flex justify-between items-center mt-3">
                                                <label class="flex items-center cursor-pointer text-gray-600 hover:bg-gray-100 px-3 py-2 rounded-md">
                                                    <i class="fas fa-image mr-2 text-green-500"></i>
                                                    <span>Photo/Video</span>
                                                    <input type="file" name="media" class="hidden" accept="image/*,video/*">
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
                            <div class="post bg-white rounded-lg shadow mb-4" data-post-id="{{ $post->id }}">
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
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
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                    </div>

                                    @if($post->type === 'share')
                                        <p class="text-gray-800 mb-2">{{ $post->content }}</p>
                                        <div class="border rounded-lg p-4 bg-gray-50">
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
                                            @if($post->originalPost->image)
                                                <img src="{{ asset('storage/' . $post->originalPost->image) }}" alt="Original post image" class="w-full rounded-lg mt-2">
                                            @endif
                                            @if($post->originalPost->video)
                                                <video controls class="w-full rounded-lg mt-2">
                                                    <source src="{{ asset('storage/' . $post->originalPost->video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                        </div>
                                    @else
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
                                    @endif

                                    <div class="flex items-center justify-between text-gray-500 border-t border-b py-2">
                                        <div class="relative group flex-1">
                                            <button class="reaction-button flex items-center hover:bg-gray-100 px-3 py-1 rounded-md transition duration-200 w-full justify-center">
                                                <i class="far fa-thumbs-up mr-2"></i>
                                                <span>Like</span>
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
                                        @foreach($post->comments->take(2) as $comment)
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
                                                        <span class="text-xs text-gray-400 ml-auto">
                                                            <i class="far fa-clock mr-1"></i>
                                                            {{ $comment->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    <form class="reply-form mt-2 hidden">
                                                        @csrf
                                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                        <div class="flex items-center">
                                                            <input type="text" name="content" class="flex-grow p-2 border rounded-l-full" placeholder="Write a reply...">
                                                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-full">Send</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($post->comments_count > 2)
                                            <button class="text-blue-500 text-sm font-semibold hover:underline view-more-comments">
                                                View all {{ $post->comments_count }} comments
                                            </button>
                                        @endif
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
@endsection