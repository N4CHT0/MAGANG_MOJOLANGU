<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                return view('home.admin');
            case 'warga':
                return view('home.warga');
            case 'rt':
                return view('home.rt');
            case 'rw':
                return view('home.rw');
            case 'kelurahan':
                return view('home.kelurahan');
            default:
                return view('home.default'); // Jika peran tidak cocok
        }
    }
}
