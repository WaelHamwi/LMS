<?php

namespace App\Livewire\Actions;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout(); 
        
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('roles');
    }

    public function render()
    {
        return view('livewire.actions.logout');
    }
}
