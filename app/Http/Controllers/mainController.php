<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class mainController extends Controller
{
    public function index()
    {
        $user = User::get();
        return view('home', compact('user'));
    }
}
