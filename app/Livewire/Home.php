<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Share;
use App\Models\like;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;

class Home extends Component
{
    public function like($id)
    {
        DB::beginTransaction();
        try {
            Like::firstOrCreate(["post_id" => $id, "user_id" => auth()->id()]);
            $post = Post::findOrFail($id);
            $post->likes += 1;
            $post->save();
            Notification::create([
                "type" => "Like Post",
                "user_id" => $post->user_id,
                "message" => auth()->user()->username . " le gusta tu publicación",
                "url" => "/post/" . $post->uuid
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->back();
    }

    public function dislike($id)
    {
        DB::beginTransaction();
        try {
            $like = Like::where(["post_id" => $id, "user_id" => auth()->id()])->first();
            $like->delete();
            $post = Post::findOrFail($id);
            $post->likes -= 1;
            $post->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect()->back();
    }

    public function sharePost($id)
    {
        DB::beginTransaction();
        try {
            Share::create([
                "user_id" => auth()->id(),
                "post_id" => $id,
            ]);
            $post = Post::findOrFail($id);
            $post->shares += 1;
            $post->save();
            Notification::create([
                "type" => "Share Post",
                "user_id" => $post->user_id,
                "message" => auth()->user()->username . " compartió tu publicación",
                "url" => "/post/" . $post->uuid
            ]);
            DB::commit();
            session()->flash('success', 'Has compartido la publicación correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Algo salió mal');
            throw $th;
        }
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.home', ['posts' => Post::with("user")->latest()->paginate(100)])->extends('layouts.app');
    }
}
