@extends('layouts.main')

@section('body')
<form action="{{ route('home.complete-registration') }}" method="post">
    @csrf

    <div class="row">
        <div class="col col-12 col-md-6">
            @input(['field' => 'realName', 'label' => trans('user.real-name'), 'help' => trans('user.real-name-help')])
        </div>
        <div class="col col-12 col-md-6">
            @input(['field' => 'name', 'label' => trans('user.name'), 'help' => trans('user.name-help')])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-4">
            @input(['field' => 'vat', 'label' => trans('user.vat'), 'help' => trans('user.vat-help')])
        </div>
        <div class="col col-12 col-md-8">
            @input(['field' => 'email', 'label' => trans('user.iban'), 'help' => trans('user.iban-help')])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-8">
            @input(['field' => 'address', 'label' => trans('user.address'), 'help' => trans('user.address-help')])
        </div>
        <div class="col col-12 col-md-4">
            @input(['field' => 'city', 'label' => trans('user.city'), 'help' => trans('user.city-help')])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-4">
            @input(['field' => 'postalCode', 'label' => trans('user.postal-code'), 'help' => trans('user.postal-code-help')])
        </div>
        <div class="col col-12 col-md-4">
            @input(['field' => 'countryCode', 'label' => trans('user.country-code'), 'help' => trans('user.country-code-help')])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-6">
            @input(['field' => 'activityProof', 'label' => trans('user.activity-proof'), 'help' => trans('user.activity-proof-help')])
        </div>
        <div class="col col-12 col-md-6">
            @input(['field' => 'wantDonation', 'label' => trans('user.want-donation'), 'help' => trans('user.want-donation-help')])
        </div>
    </div>
    <div class="row">
        <div class="col col-12 col-md-4">
            @input(['field' => 'iban', 'label' => trans('user.iban'), 'help' => trans('user.iban-help')])
        </div>
    </div>
</form>
@endsection
