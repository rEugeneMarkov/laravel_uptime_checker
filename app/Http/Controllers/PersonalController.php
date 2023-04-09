<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {
        $websites = Website::where('user_id', '=', auth()->user()->id)->get();
        return view('personal.main.index', compact('websites'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('personal.main.profile', compact('user'));
    }
}
