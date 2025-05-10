<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\User;
use App\Models\Notification;

class Admin extends Home
{
    public $users;
    public $posts;
    public $channels;
    public $squads;
    public $banned_users;

    public function mount()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'No tienes permisos de administrador');
        }

        // Inicializar propiedades del Home
        $this->posts = Post::with('user')->latest()->get();
        $this->users = User::all();
        $this->channels = \App\Models\Page::all();
        $this->squads = \App\Models\Group::all();
        $this->banned_users = User::where('banned_to', '>', now('Asia/Yangon'))->get();
    }

    public function render()
    {
        if (auth()->user()->role !== 'admin') {
            return view('livewire.home');
        }
        return view('livewire.admin')->extends('layouts.app');
    }

    public function ban($userid)
    {
        $user = User::findOrFail($userid);
        if ($user->is_banned >= 3) {
            $user->update([
                'is_private' => 1,
                'is_banned' => 0,
                'banned_at' => null,
                'banned_to' => null,
            ]);
            Notification::create([
                "type" => "Temporary Lock",
                "user_id" => $user->id,
                "message" => $user->username . " Se te ha bloqueado temporalmente.",
                "url" => "logout"
            ]);
        } else {
            $user->update([
                'is_banned' => $user->is_banned + 1,
                'banned_at' => now('Asia/Yangon'),
                'banned_to' => now('Asia/Yangon')->addMinute(5)
            ]);

            Notification::create([
                "type" => "Ban User",
                "user_id" => $user->id,
                "message" => $user->username . " Se te ha prohibido el acceso a la plataforma.",
                "url" => "/profile/" . $user->username
            ]);
        }
        return redirect()->route('all-users');
    }

    public function unban($userid)
    {
        $user = User::findOrFail($userid);
        $user->update([
            'banned_to' => now('Asia/Yangon'),
        ]);
        return redirect()->route('all-users');
    }

    public function unlock($userid)
    {
        $user = User::findOrFail($userid);
        $user->update([
            'is_private' => 0,
        ]);
        return redirect()->route('all-users');
    }
}
