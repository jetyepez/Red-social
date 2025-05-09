<?php

namespace App\Livewire;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\SavedPost;
use App\Models\Post;

class SavedPostController extends Component
{

    public function render()
    {
        return view('livewire.saved-post')->extends('layouts.app');
    }

    public function savePost($post_id)
    {
        DB::beginTransaction();
        try {
            SavedPost::firstOrCreate(["post_id" => $post_id, "user_id" => auth()->id()]);
            $post = Post::findOrFail($post_id);

            Notification::create([
                "type" => "Guardar Publicación",
                "user_id" => $post->user_id,
                "message" => auth()->user()->username . " guardó tu publicación",
                "url" => "/post/" .  $post->uuid
            ]);
            DB::commit();
            session()->flash('success', 'Publicación guardada correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Algo salió mal');
            throw $th;
        }
        return redirect()->back();
    }

    public function unsavePost($post_id)
    {
        DB::beginTransaction();
        try {
            $save = SavedPost::where(["post_id" => $post_id, "user_id" => auth()->id()])->first();
            $save->delete();
            DB::commit();
            session()->flash('success', 'Publicación eliminada correctamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            session()->flash('error', 'Algo salió mal');
            throw $th;
        }
        return redirect()->back();
    }
}
