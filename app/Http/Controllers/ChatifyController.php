<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChatifyController extends Controller
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
} 