<?php

namespace App\Http\Controllers;

use App\Models\Social;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateArtistPost;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.profiles.index', ['record' => auth('web-artists')->user()]);
    }

    public function update(UpdateArtistPost $request)
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
        if (!empty($artist->password) && !empty($artist->repassword)) {
            $artist->password = \Hash::make($request->password);
        }
        $artist->save();
        return redirect()->route('profile.index');
    }

    public function social(Request $request)
    {
        $record = auth('web-artists')->user();

        $social = Social::where('artist_id', $record->id)->get();

        return view('pages.profiles.social', [
            'record' => $record,
            'social' => $social
        ]);
    }
}
