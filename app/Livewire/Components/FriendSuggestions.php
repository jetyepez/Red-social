<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class FriendSuggestions extends Component
{
    public $suggestions = [];
    public $searchTerm = '';

    public function mount()
    {
        $this->loadSuggestions();
    }

    public function loadSuggestions()
    {
        $currentUser = auth()->user();
        
        // Obtener usuarios que no son amigos y no son el usuario actual
        $this->suggestions = User::where('id', '!=', $currentUser->id)
            ->whereDoesntHave('friends', function ($query) use ($currentUser) {
                $query->where('friend_id', $currentUser->id);
            })
            ->whereDoesntHave('friendRequests', function ($query) use ($currentUser) {
                $query->where('sender_id', $currentUser->id);
            })
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%')
                      ->orWhere('username', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->take(5)
            ->get();
    }

    public function sendFriendRequest($userId)
    {
        $currentUser = auth()->user();
        
        // Verificar si ya existe una solicitud
        if (!$currentUser->friendRequests()->where('receiver_id', $userId)->exists()) {
            $currentUser->friendRequests()->create([
                'receiver_id' => $userId,
                'status' => 'pending'
            ]);
            
            $this->loadSuggestions(); // Recargar sugerencias
            session()->flash('success', 'Solicitud de amistad enviada');
        }
    }

    public function updatedSearchTerm()
    {
        $this->loadSuggestions();
    }

    public function render()
    {
        return view('livewire.components.friend-suggestions');
    }
} 