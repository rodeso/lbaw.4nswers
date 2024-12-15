<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    public function about()
    {
        $notifications = Controller::getNotifications();

        return view('about-us', compact('notifications'));
    }
}
