<?php

namespace App\Livewire;

use Livewire\Component;

class CreateSquad extends Component
{
    public function render()
    {
        return view('livewire.create-squad')->extends('layouts.app');
    }
}
