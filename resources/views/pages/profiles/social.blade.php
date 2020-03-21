@extends("layouts.main")

@section('body')
    <div class="row mt-5">
        <div class="col col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ trans('profile.title-social') }}
                </div>
                <div class="card-body">
                    <p>{{ trans('profile.you-can-connect-to-this-platform') }}</p>
                    <a href="{{ route('register.provider', ['provider' => 'facebook']) }}" class="btn btn-secondary">
                        <i class="fab fa-facebook-square"></i>
                        {{ trans('profile.facebook') }}
                    </a>

                    <a href="{{ route('register.provider', ['provider' => 'twitter']) }}" class="btn btn-secondary">
                        <i class="fab fa-twitter-square"></i>
                        {{ trans('profile.twitter') }}
                    </a>

                    <a href="{{ route('register.provider', ['provider' => 'youtube']) }}" class="btn btn-secondary">
                        <i class="fab fa-youtube-square"></i>
                        {{ trans('profile.youtube') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col col-12 col-md-4">
            @include("pages.profiles.partials.sidebar")
        </div>
    </div>
@endsection
