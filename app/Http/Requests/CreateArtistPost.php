<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArtistPost extends FormRequest
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

    public function attributes()
    {
        return [
            'realName' => trans('register.real-name'),
            'name' => trans('register.name'),
            'email' => trans('register.email'),
            'iban' => trans('artist.iban'),
            'wantDonation' => trans('artist.want-donation')
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
            'email' => 'required|unique:artists,email',
            'iban' => 'required_if:wantDonation,1'
        ];
    }
}
