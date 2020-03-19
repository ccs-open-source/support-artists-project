<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.profiles.index', ['record' => auth('web-artists')->user()]);
    }

    public function update(Request $request)
    {
        $payload = $request->only(['name', 'realName', 'password', 'address', 'city', 'postalCode', 'countryCode', 'vat', 'activityProof', 'iban', 'wantDonation']);

        $artist = auth('web-artists')->user();
        $artist->name = $request->name;
        $artist->realName = $request->realName;
        $artist->address = $request->address;
        $artist->city = $request->city;
        $artist->postalCode = $request->postalCode;
        $artist->countryCode = $request->countryCode;
        $artist->vat = $request->vat;
        $artist->activityProof = $request->activityProof;
        $artist->iban = $request->iban;
        $artist->wantDonation = $request->wantDonation;

        $artist->save();

        return redirect()->route('profile.index');
    }
}
