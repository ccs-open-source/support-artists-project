<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('pages.home.login');
    }

    /**
     *  
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['isRegistrationComplete'] = 1;

        if (\Auth::guard('web-artists')->attempt($credentials)) {
            return redirect()->intended('/');
        }

        return redirect()->route('home.login');
    }

}
