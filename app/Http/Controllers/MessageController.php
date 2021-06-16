<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::all()
            ->where('type', '!=', 'admin');

        return view('live-chat', [
            'users' => $users
        ]);
    }

    public function show(User $recipient)
    {
        $users = User::all()
            ->where('type', '!=', 'admin');

        return view('live-chat', [
            'users' => $users,
            'recipient' => $recipient
        ]);
    }
}
