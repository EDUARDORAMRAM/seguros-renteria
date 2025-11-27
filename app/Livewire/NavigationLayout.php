<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavigationLayout extends Component
{
    public function logout()
    {
        Auth::guard('web')->logout();
        
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.navigation-layout');
    }
}