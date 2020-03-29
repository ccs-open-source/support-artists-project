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
                    @if(!empty($social) && $social->where('provider', 'facebook')->count() <= 0)
                    <a href="{{ route('register.provider', ['provider' => 'facebook', 'redirectTo' => route('profile.social')]) }}" class="btn btn-secondary">
                        <i class="fab fa-facebook-square"></i>
                        {{ trans('profile.facebook') }}
                    </a>
                    @else
                        <div class="btn btn-success">
                            <i class="fab fa-facebook-square"></i>
                            {{ trans('profile.connected') }}
                        </div>
                    @endif

                    @if(!empty($social) && $social->where('provider', 'twitter')->count() <= 0)
                    <a href="{{ route('register.provider', ['provider' => 'twitter', 'redirectTo' => route('profile.social')]) }}" class="btn btn-secondary">
                        <i class="fab fa-twitter-square"></i>
                        {{ trans('profile.twitter') }}
                    </a>
                    @else
                        <div class="btn btn-success">
                            <i class="fab fa-twitter-square"></i>
                            {{ trans('profile.connected') }}
                        </div>
                    @endif

                    @if(!empty($social) && $social->where('provider', 'google')->count() <= 0)
                    <a href="{{ route('register.provider', ['provider' => 'google', 'redirectTo' => route('profile.social')]) }}" class="btn btn-secondary">
                        <i class="fab fa-google"></i>
                        {{ trans('profile.google') }}
                    </a>
                    @else
                        <div class="btn btn-success">
                            <i class="fab fa-google"></i>
                            {{ trans('profile.connected') }}
                        </div>
                    @endif

                    @if(!empty($social) && $social->where('provider', 'patreon')->count() <= 0)
                        <a href="{{ route('register.provider', ['provider' => 'patreon', 'redirectTo' => route('profile.social')]) }}" class="btn btn-secondary">
                            <i class="fab fa-patreon"></i>
                            {{ trans('profile.patreon') }}
                        </a>
                    @else
                        <div class="btn btn-success">
                            <i class="fab fa-patreon"></i>
                            {{ trans('profile.connected') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col col-12 col-md-4">
            @include("pages.profiles.partials.sidebar")
        </div>
    </div>
@endsection
