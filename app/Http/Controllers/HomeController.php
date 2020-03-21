<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\CreateArtistPost;

class HomeController extends Controller
{
    /**
     * Homepage
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $streams = Stream::whereNull('cancel_at')
            ->orderBy('created_at', 'desc')
            ->get();

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
    public function completeRegistration(Request $request)
    {
        $artist = session()->get('artist');
        if (!empty($artist->isRegistrationComplete)) {
            return redirect()->route('home.index')->withErrors([
                'artist' => 'You account is already active'
            ]);
        }

        return view('pages.home.complete-registration', [
            'record' => $artist
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finishedRegistration(CreateArtistPost $request)
    {
        $data = $request->except(['_csrf_token']);

        $artist = new Artist;
        if (session()->has('artist')) {
            $artist = session()->get('artist');
        }

        $artist->email = $data['email'];
        $artist->name = $data['name'];
        $artist->realName = $data['realName'];
        $artist->isRegistrationComplete = 1;
        $artist->address = $data['address'] ?? '';
        $artist->city = $data['city'] ?? '';
        $artist->password = \Hash::make($data['password']);
        $artist->countryCode = $data['countryCode'] ?? '';
        $artist->postalCode = $data['postalCode'] ?? '';
        $artist->vat = $data['vat'] ?? '';
        $artist->iban = $data['iban'] ?? '';
        $artist->activityProof = $data['activityProof'] ?? '';
        $artist->wantDonation = $data['wantDonation'] ?? 0;

        $artist->save();
        session()->remove('artist');

        return redirect()->route('home.index');
    }
}
