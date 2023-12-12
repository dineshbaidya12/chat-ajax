<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class mainController extends Controller
{
    public function index()
    {
        $user = User::get();
        return view('home', compact('user'));
    }
    public function sendMsg(Request $request)
    {
        $cleanContent = Purifier::clean($request->input('type_message'));
        $contentWithLineBreaks = nl2br($cleanContent);
        dd($contentWithLineBreaks);
    }
}
