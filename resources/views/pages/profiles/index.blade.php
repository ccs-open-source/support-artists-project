@extends("layouts.main")

@section('body')
    <div class="row mt-5">
        <div class="col col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ trans('profile.title') }}
                </div>
                <div class="card-body">
                    @if($record->isVerified == 0)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">{{ trans('profile.unverified-account-can-be-verified-title') }}</h4>
                        <p>{{ trans('profile.unverified-account-can-be-verified') }}</p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                    </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="post" class="mt-5">
                        @csrf

                        <div class="row">
                            <div class="col col-12 col-md-6">
                                @input(['field' => 'realName', 'label' => trans('artist.real-name'), 'help' => trans('artist.real-name-help')])
                            </div>
                            <div class="col col-12 col-md-6">
                                @input(['field' => 'name', 'label' => trans('artist.name'), 'help' => trans('artist.name-help'), 'validation' => ['required' => true]])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 col-md-8">
                                @input(['field' => 'email', 'label' => trans('artist.email'), 'help' => trans('artist.email-help')])
                            </div>
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'password', 'label' => trans('artist.password'), 'help' => trans('artist.password-help'), 'type' => 'password'])
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col col-12 col-md-8">
                                @input(['field' => 'address', 'label' => trans('artist.address'), 'help' => trans('artist.address-help')])
                            </div>
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'city', 'label' => trans('artist.city'), 'help' => trans('artist.city-help')])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'postalCode', 'label' => trans('artist.postal-code'), 'help' => trans('artist.postal-code-help')])
                            </div>
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'countryCode', 'label' => trans('artist.country-code'), 'help' => trans('artist.country-code-help')])
                            </div>
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'vat', 'label' => trans('artist.vat'), 'help' => trans('artist.vat-help')])
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col col-12 col-md-6">
                                @input(['field' => 'activityProof', 'label' => trans('artist.activity-proof'), 'help' => trans('artist.activity-proof-help')])
                            </div>
                            <div class="col col-12 col-md-6">
                                @checkbox([
                                    'field' => 'wantDonation',
                                    'label' => trans('artist.want-donation'),
                                    'class' => 'mt-4',
                                    'validation' => [

                                    ]
                                ])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-12 col-md-4">
                                @input(['field' => 'iban', 'label' => trans('artist.iban'), 'help' => trans('artist.iban-help')])
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col col-12 col-md-4">
                                @btnPrimary(['title' => trans('actions.submit')])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-4">
            <h3>{{ trans('profile.hi-artist', ['artist' => $record->realName]) }}</h3>
            <img src="{{ $record->avatar }}?s=500" alt="{{ $record->name }}" class="img-fluid img-thumbnail rounded mb-2">
            <div class="card">
                <div class="card-header">
                    {{ trans('profile.menu') }}
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="#">{{ trans('profile.menu-general') }}</a></li>
                    <li class="list-group-item"><a href="#">{{ trans('profile.menu-stream') }}</a></li>
                    <li class="list-group-item"><a href="#">{{ trans('profile.menu-donation') }}</a></li>
                    <li class="list-group-item"><a href="#">{{ trans('profile.menu-security') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
