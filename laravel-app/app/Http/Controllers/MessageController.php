<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Conversation;
use App\Events\NewMessageEvent;
use App\Events\UserTypingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhere('other_user_id', Auth::id());
        })
        ->with(['user', 'otherUser', 'lastMessage'])
        ->withCount(['messages as unreadCount' => function ($query) {
            $query->where('read', false)->where('sender_id', '!=', Auth::id());
        }])
        ->orderBy('updated_at', 'desc')
        ->get();

        $friends = Auth::user()->friends;

        return view('messages.index', compact('conversations', 'friends'));
    }

    public function show($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();
        $otherUser = $conversation->user_id === Auth::id() ? $conversation->otherUser : $conversation->user;

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);

        $conversations = Conversation::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhere('other_user_id', Auth::id());
        })
        ->with(['user', 'otherUser', 'lastMessage'])
        ->withCount(['messages as unreadCount' => function ($query) {
            $query->where('read', false)->where('sender_id', '!=', Auth::id());
        }])
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('messages.show', compact('conversation', 'messages', 'otherUser', 'conversations'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'conversation_id' => 'required|exists:conversations,id',
                'content' => 'required_without:image|string|nullable',
                'image' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240', // Max 10MB
            ]);

            $message = new Message([
                'conversation_id' => $request->conversation_id,
                'sender_id' => Auth::id(),
                'content' => $request->content,
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
                
                // Resize and compress the image
                $img = Image::make($image->getRealPath());
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $path = 'message_images/' . $filename;
                Storage::disk('public')->put($path, $img->encode('jpg', 80));
                
                $message->image_url = Storage::url($path);
            }

            $message->save();

            $conversation = Conversation::find($request->conversation_id);
            $conversation->touch();

            broadcast(new NewMessageEvent($message))->toOthers();

            return response()->json($message->load('sender'));
        } catch (\Exception $e) {
            Log::error('Message store error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while sending the message.'], 500);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'recipient' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $conversation = Conversation::firstOrCreate([
            'user_id' => Auth::id(),
            'other_user_id' => $request->recipient,
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $request->message,
        ]);

        broadcast(new NewMessageEvent($message))->toOthers();

        return redirect()->route('messages.show', $conversation->id);
    }

    public function typing(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        broadcast(new UserTypingEvent(Auth::user(), $request->conversation_id))->toOthers();

        return response()->json(['success' => true]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $messages = Message::whereHas('conversation', function ($q) {
            $q->where('user_id', Auth::id())
              ->orWhere('other_user_id', Auth::id());
        })
        ->where('content', 'LIKE', "%{$query}%")
        ->with(['conversation.user', 'conversation.otherUser', 'sender'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        
        return response()->json($messages);
    }
}
