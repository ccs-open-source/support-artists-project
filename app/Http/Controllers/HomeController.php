<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Homepage
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function index(Request $request)
    {
        $streams = Stream::all();

        return view('homepage', [
            'streams' => $streams
        ]);
    }

    /**
     * Complete Registration
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    function completeRegistration(Request $request)
    {
        if(!session()->has('artist')) {
            return redirect()->route('home')->withErrors([
                'artist' => 'You must first try to register'
            ]);
        }

        $artist = session()->get('artist');
        if (!empty($artist->isRegistrationComplete)) {
            return redirect()->route('home')->withErrors([
                'artist' => 'You account is already active'
            ]);
        }

        return view('pages.home.complete-registration', [
            'record' => $artist
        ]);
    }
}
