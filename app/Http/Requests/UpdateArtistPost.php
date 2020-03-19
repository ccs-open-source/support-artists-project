<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtistPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attribute()
    {
        return [
            'realName' => trans('register.real-name'),
            'name' => trans('register.name'),
            'iban' => trans('artist.iban'),
            'wantDonation' => trans('artist.want-donation'),
            'password' => trans('artist.password'),
            'repassword' => trans('artist.repassword')
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'realName' => 'required',
            'iban' => 'required_if:wantDonation,1',
            'password' => 'confirmed'
        ];
    }
}
