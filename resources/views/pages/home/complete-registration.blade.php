@extends('layouts.main')

@section('body')
    <div class="row mt-5">
        <div class="col-12 col-md-12">
            <h2>
                {{ trans('artist.complete-registration') }}
                <small>{{ trans('artist.complete-registration-help') }}</small>
            </h2>
        </div>
    </div>

    @include('pages.profiles.partials.form-artist', ['route' => route('home.registration'), 'type' => 'complete-registration' ])
@endsection
