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

                    @include('pages.profiles.partials.form-artist', ['route' => route('profile.update'), 'type' => 'profile' ])
                </div>
            </div>
        </div>

        <div class="col col-12 col-md-4">
            @include("pages.profiles.partials.sidebar")
        </div>
    </div>
@endsection
