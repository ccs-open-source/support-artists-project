@extends("layouts.main")

@section('body')
    <div class="row mt-5">
        <div class="col col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ trans('profile.title') }}
                </div>
                <div class="card-body">
                    @if($artist->isVerified == 0)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">{{ trans('profile.unverified-account-can-be-verified-title') }}</h4>
                        <p>{{ trans('profile.unverified-account-can-be-verified') }}</p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                    </div>
                    @endif

                    

                    
                </div>
            </div>
        </div>
        <div class="col col-12 col-md-4">
            <h3>{{ trans('profile.hi-artist', ['artist' => $artist->realName]) }}</h3>
            <img src="{{ $artist->avatar }}?s=500" alt="{{ $artist->name }}" class="img-fluid img-thumbnail rounded mb-2">
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
