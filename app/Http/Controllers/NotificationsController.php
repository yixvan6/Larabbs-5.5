<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        \Auth::user()->markAsRead();
        $notifications = \Auth::user()->notifications()->paginate();

        return view('notifications.index', compact('notifications'));
    }
}
