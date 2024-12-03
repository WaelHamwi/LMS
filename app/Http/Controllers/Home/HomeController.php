<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{


    public function index()
    {
        return view('livewire.pages.auth.roles');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
