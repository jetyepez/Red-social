<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Pusher\Pusher;

class ChatController extends Controller
{
    public function getOnlineUsers()
    {
        $onlineUsers = User::where('last_seen_at', '>=', now()->subMinutes(5))
            ->where('id', '!=', auth()->id())
            ->select('id', 'first_name', 'last_name', 'profile')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'avatar' => $user->profile ? asset('storage/' . $user->profile) : asset('images/default-avatar.png'),
                ];
            });

        return response()->json($onlineUsers);
    }

    public function updateLastSeen()
    {
        auth()->user()->update(['last_seen_at' => now()]);
        return response()->json(['status' => 'success']);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'to' => 'required|exists:users,id'
        ]);

        $message = auth()->user()->messages()->create([
            'to' => $request->to,
            'body' => $request->message,
        ]);

        // Broadcast usando Pusher
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        $pusher->trigger('chat-channel', 'new-message', [
            'message' => $message,
            'user' => auth()->user()
        ]);

        return response()->json($message);
    }

    public function getMessages($userId)
    {
        $messages = auth()->user()->messages()
            ->where(function ($query) use ($userId) {
                $query->where('from', auth()->id())
                    ->where('to', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('from', $userId)
                    ->where('to', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'body' => $message->body,
                    'created_at' => $message->created_at->format('H:i'),
                    'is_mine' => $message->from === auth()->id()
                ];
            });

        return response()->json($messages);
    }
} 