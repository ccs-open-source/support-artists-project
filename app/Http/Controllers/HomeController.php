<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(Request $request)
    {
        return view('homepage');
    }

    function completeRegistration(Request $request)
    {
        if(!session()->has('artist')) {
            return redirect()->route('home')->withErrors([
                'artist' => 'You must first try to register'
            ]);
        }

        $artist = session()->get('artist');
        if (!empty($artist->isActive)) {
            return redirect()->route('home')->withErrors([
                'artist' => 'You account is already active'
            ]);
        }

    }
}
