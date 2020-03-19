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
            <h3>{{ trans('profile.hi-artist', ['artist' => $record->realName]) }}</h3>
            <img src="{{ $record->avatar }}?s=500" alt="{{ $record->name }}" class="img-fluid img-thumbnail rounded mb-2">
            <div class="card">
                <div class="card-header">
                    {{ trans('profile.menu') }}
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action 
                        @inUrl('profile') 
                        active 
                        @endinUrl">
                        {{ trans('profile.menu-general') }}
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        {{ trans('profile.menu-stream') }}
                    </a>
                    <a href="{{ route('profile.social') }}" class="list-group-item list-group-item-action">
                        {{ trans('profile.menu-social') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
