<?php

namespace LaravelForum\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    // list all the notifications...
    public function notifications(){
        // mark all as read
        auth()->user()->unreadNotifications->markAsRead();
       // dd(auth()->user()->notifications());
        // display all notifications..
        return view('users.notifications', [
            'notifications' => auth()->user()->notifications()->paginate(5)
        ]);
    }
}
