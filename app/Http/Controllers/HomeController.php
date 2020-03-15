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
        if(!session()->has('artist')) {
            return redirect()->route('home.index')->withErrors([
                'artist' => 'You must first try to register'
            ]);
        }

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
    public function finishedRegistration(Request $request)
    {
        $data = $request->except(['_csrf_token']);

        $artist = session()->get('artist');

        $artist->realName = $data['realName'];
        $artist->isRegistrationComplete = 1;
        $artist->address = $data['address'] ?? '';
        $artist->city = $data['city'] ?? '';
        $artist->countryCode = $data['countryCode'] ?? '';
        $artist->postalCode = $data['postalCode'] ?? '';
        $artist->vat = $data['vat'] ?? '';
        $artist->iban = $data['iban'] ?? '';
        $artist->activityProof = $data['activityProof'] ?? '';
        $artist->wantDonation = $data['wantDonation'] ?? 0;

        $artist->save();
        session()->put('artist', $artist);

        return redirect()->route('home.index');
    }


}