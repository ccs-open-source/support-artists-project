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
            $user = auth('web-artists')->user();
            return redirect()->intended('/')->with('message', ['type' => 'success', 'message' => trans('profile.welcome-log-in-message', ['name' => $user->name])]);
        }

        return redirect()->route('home.login');
    }
}
