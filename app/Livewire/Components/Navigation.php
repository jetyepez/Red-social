<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Navigation extends Component
{
    public $isOpen = false;

    public function mount()
    {
        $this->isOpen = false;
    }

    public function toggleMenu()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        return view('livewire.components.navigation');
    }
} 