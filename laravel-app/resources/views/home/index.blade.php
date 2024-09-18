<!-- resources/views/home/index.blade.php -->
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex">
            <!-- Left Sidebar -->
            <div class="w-1/4 pr-4 hidden lg:block">
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <ul class="space-y-2">
                        <li><a href="#" class="flex items-center text-gray-700 hover:bg-gray-100 px-2 py-1 rounded"><i class="fas fa-user-friends mr-2 text-blue-500"></i> Friends</a></li>
                        <li><a href="#" class="flex items-center text-gray-700 hover:bg-gray-100 px-2 py-1 rounded"><i class="fas fa-users mr-2 text-blue-500"></i> Groups</a></li>
                        <li><a href="#" class="flex items-center text-gray-700 hover:bg-gray-100 px-2 py-1 rounded"><i class="fas fa-store mr-2 text-blue-500"></i> Marketplace</a></li>
                        <li><a href="#" class="flex items-center text-gray-700 hover:bg-gray-100 px-2 py-1 rounded"><i class="fas fa-tv mr-2 text-blue-500"></i> Watch</a></li>
                        <li><a href="#" class="flex items-center text-gray-700 hover:bg-gray-100 px-2 py-1 rounded"><i class="fas fa-history mr-2 text-blue-500"></i> Memories</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="w-full lg:w-1/2 px-4">
                <!-- Create Post Section -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-4">
                        <div class="flex items-center">
                            <img src="{{ auth()->user()->profile_picture_url ? asset('storage/' . auth()->user()->profile_picture_url) : asset('images/default-avatar.jpg') }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="w-10 h-10 rounded-full mr-4 object-cover">
                            <div class="w-full">
                                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <textarea name="content" rows="2" class="w-full p-3 bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="What's on your mind, {{ auth()->user()->name }}?"></textarea>
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

                <!-- Stories Section -->
                <div class="bg-white rounded-lg shadow mb-6 p-4">
                    <h3 class="text-lg font-semibold mb-4">Stories</h3>
                    <div class="flex space-x-2 overflow-x-auto">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="flex-shrink-0 w-28 h-40 bg-gray-300 rounded-lg relative overflow-hidden">
                                <img src="https://picsum.photos/200/300?random={{ $i }}" alt="Story {{ $i }}" class="w-full h-full object-cover">
                                <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black to-transparent">
                                    <span class="text-white text-xs">User {{ $i + 1 }}</span>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Posts Feed -->
                <div class="space-y-6">
                    @forelse($posts->sortByDesc('created_at') as $post)
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
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
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

            <!-- Right Sidebar -->
            <div class="w-1/4 pl-4 hidden lg:block">
                <div class="bg-white rounded-lg shadow p-4 mb-4">
                    <h3 class="font-semibold mb-2">Sponsored</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <img src="https://picsum.photos/100/100?random=1" alt="Ad 1" class="w-16 h-16 object-cover rounded mr-2">
                            <div>
                                <h4 class="font-semibold text-sm">Product Name</h4>
                                <p class="text-xs text-gray-500">Short description</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <img src="https://picsum.photos/100/100?random=2" alt="Ad 2" class="w-16 h-16 object-cover rounded mr-2">
                            <div>
                                <h4 class="font-semibold text-sm">Another Product</h4>
                                <p class="text-xs text-gray-500">Brief info</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-semibold mb-2">Contacts</h3>
                    <ul class="space-y-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <li class="flex items-center">
                                <img src="https://picsum.photos/50/50?random={{ $i }}" alt="Contact {{ $i }}" class="w-8 h-8 rounded-full mr-2">
                                <span class="text-sm">User {{ $i }}</span>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this at the end of your body tag -->
<div id="shareModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">Share this post</h3>
            <form method="POST" action="" id="shareForm">
                @csrf
                <textarea name="content" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="3" placeholder="Write a caption (optional)"></textarea>
                <div class="mt-4 bg-gray-100 p-3 rounded-lg">
                    <div class="flex items-center mb-2">
                        <img src="" alt="" class="w-8 h-8 rounded-full mr-2 object-cover" id="shareOriginalUserImg">
                        <div>
                            <h4 class="font-semibold text-sm" id="shareOriginalUserName"></h4>
                            <p class="text-xs text-gray-500" id="shareOriginalPostDate"></p>
                        </div>
                    </div>
                    <p class="text-gray-800 text-sm" id="shareOriginalContent"></p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeShareModal" type="button" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="mt-3 px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Share
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

