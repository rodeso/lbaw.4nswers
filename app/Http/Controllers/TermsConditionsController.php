<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsConditionsController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get logged-in user

        return view('terms&conditions', compact('user'));
    }
}
