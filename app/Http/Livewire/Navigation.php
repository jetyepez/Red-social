<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;

class Navigation extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (auth()->check()) {
            $this->notifications = Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->user_id === auth()->id()) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.navigation');
    }
} 