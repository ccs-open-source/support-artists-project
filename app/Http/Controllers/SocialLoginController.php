<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Social;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect to desire provider
     *
     * @param Request $request
     * @param string $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider(Request $request, string $provider)
    {
        if ($request->get('redirectTo')) {
            session()->put('redirectTo', $request->get('redirectTo'));
        }

        return Socialite::driver($provider)
            ->redirect();
    }

    /**
     * Handle callback from provider
     *
     * @param Request $request
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback(Request $request, string $provider)
    {
        $url = session()->get('redirectTo');

        $user = Socialite::driver($provider)->user();

        if (auth('web-artists')->user()) {
            $this->handleProviderUserAssociation($user, $provider, auth('web-artists')->user());
            if (!empty($url)) {
                return redirect()->to($url);
            }
            return redirect()->route('home.index');
        }

        $artist = Artist::with(['social' => function ($query) use ($provider) {
            return $query->where('provider', $provider);
        }])->where('email', $user->getEmail())->first();

        if (!empty($artist) && $artist->isRegistrationComplete == 1) {
            $this->handleProviderUserAssociation($user, $provider, $artist);
            if (!empty($url)) {
                return redirect()->to($url);
            }
            return redirect()->route('home.index');
        }

        $this->handleProviderNewArtist($user, $provider);
        if (!empty($url)) {
            return redirect()->to($url);
        }
        return redirect()->route('home.registration');
    }

    /**
     * Handle Response in order to associate user with provider
     *
     * @param mixed $user
     * @param string $provider
     * @param Artist $artist
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleProviderUserAssociation($user, string $provider, Artist $artist)
    {
        $social = new Social;
        if ($artist->social->first()) {
            $social = $artist->social->first();
        }

        $social->artist_id = $artist->id;
        $social->provider = $provider;
        $social->provider_id = $user->getId();
        $social->data = json_encode($user->getRaw());
        $social->save();
    }

    /**
     * @param mixed $user
     * @param string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleProviderNewArtist($user, string $provider)
    {
        $artist = new Artist;
        $artist->realName = $user->getName();
        $artist->email = $user->getEmail();
        $artist->avatar = $user->getAvatar();
        $artist->isRegistrationComplete = 0;

        $artist->save();

        $artist->social()->save(
            new Social([
                'provider' => $provider,
                'provider_id' => $user->getId(),
                'data' => json_encode($user->getRaw())
            ])
        );

        session()->put('artist', $artist);
    }
}
