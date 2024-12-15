<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TermsConditionsController extends Controller
{
    public function index()
    {
        $notifications = Controller::getNotifications();

        $user = Auth::user(); // Get logged-in user

        return view('terms&conditions', compact('user', 'notifications'));
    }
}
