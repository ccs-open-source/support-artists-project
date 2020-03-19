@extends('layouts.main')

@section('body')

    <div class="row mt-5">
        <div class="col col-12 col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header">
                    {{ trans('register.log-in') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('home.login') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col col-12">
                                @input(['field' => 'email', 'label' => trans('register.email')])
                            </div>

                        </div>
                        <div class="row">
                            <div class="col col-12">
                                @input(['field' => 'password', 'type' => 'password', 'label' => trans('register.password')])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-12 text-right">
                                @btnPrimary(['title' => trans('actions.submit')])
                            </div>
                        </div>

                        <hr class="mt-4">
                        <div class="text-center">
                            <p class="text-center">{{ trans('register.or-can-log-in-with-social') }}</p>

                            <a href="{{ route('register.provider', ['provider' => 'facebook']) }}" class="btn btn-secondary">
                                <i class="fab fa-facebook-square"></i>
                                {{ trans('register.facebook') }}
                            </a>

                            <a href="{{ route('register.provider', ['provider' => 'twitter']) }}" class="btn btn-secondary">
                                <i class="fab fa-twitter-square"></i>
                                {{ trans('register.twitter') }}
                            </a>

                            <a href="{{ route('register.provider', ['provider' => 'youtube']) }}" class="btn btn-secondary">
                                <i class="fab fa-youtube-square"></i>
                                {{ trans('register.youtube') }}
                            </a>
                        </div>

                    </form>
                </div>
                <div class="card-footer text-muted">
                    <a href="{{ route('home.registration') }}">
                        {{ trans('register.not-account-yet') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
