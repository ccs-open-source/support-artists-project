<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStreamPost extends FormRequest
{

    protected $redirectRoute = 'profile.stream.create';

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
            'title' => trans('profile.stream-title'),
            'slug' => trans('profile.stream-slug'),
            'provider' => trans('profile.stream-provider'),
            'provider_id' => trans('profile.stream-provider-id')
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
            'title' => 'required',
            'provider' => 'required',
            'provider_id' => 'required'
        ];
    }
}
