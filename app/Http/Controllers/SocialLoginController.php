<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider(Request $request, string $provider)
    {
        return Socialite::driver($provider)
//            ->with(['hd' => 'example.com'])
            ->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        $user = Socialite::driver($provider)->user();

        $artist = new Artist;
        $artist->name = $user->getName();
        $artist->email = $user->getEmail();
        $artist->avatar = $user->getAvatar();
        $artist->facebookId = $user->getId(); // @todo
        $artist->save();

        session()->put('artist', $artist);
        return redirect()->route('home');
    }
}
