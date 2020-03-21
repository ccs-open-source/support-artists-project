<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Social;
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

        $artist = Artist::with(['social' => function($query) use ($provider) {
            return $query->where('provider', $provider);
        }])->where('email', $user->getEmail())->first();

        if (!empty($artist) && $artist->isRegistrationComplete == 1) {

            $social = new Social;
            if ($artist->social->first()) {
                $social = $artist->social->first();
            }
            $social->artist_id = $artist->id;
            $social->provider = $provider;
            $social->provider_id = $user->getId();
            $social->data = json_encode($user->getRaw());
            $social->save();

            return redirect()->route('home.index');
        } else if(empty($artist)) {
            $artist = new Artist;
        }

        $artist->realName = $user->getName();
        $artist->email = $user->getEmail();
        $artist->avatar = $user->getAvatar();
        $artist->isRegistrationComplete = 0;
        $artist->save();

        $social = new Social;
        $social->artist_id = $artist->id;
        $social->provider = $provider;
        $social->provider_id = $user->getId();
        $social->data = json_encode($user->getRaw());
        $social->save();

        session()->put('artist', $artist);
        return redirect()->route('home.registration');
    }
}
