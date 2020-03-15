@extends('layouts.main')

@section('body')

    @if(isset($streams) && !empty($streams))
        <div class="row">
            @foreach($streams as $stream)
                <div class="col col-12 col-md-4 mt-5">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <span>
                                    {{ $stream->title }}
                                    @if(!empty($stream->artist->isVerified))
                                        <i class="fas fa-check-circle text-success" title="{{ trans('stream.is-verified') }}"></i>
                                    @endif
                                </span>
                                @if($stream->isLive)
                                    <span class="badge badge-warning">{{ trans('stream.is-live') }}</span>
                                @endif
                            </div>
                        </div>
                        <img class="card-img-top" src="https://via.placeholder.com/286x180.png?text={{ urlencode($stream->title) }}" alt="{{ $stream->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $stream->title }} <small>{{ $stream->artist->name }}</small></h5>
                            <p class="card-text">
                                @foreach($stream->tags as $tags)
                                    <span class="badge badge-primary">{!! $tags !!}</span>
                                @endforeach
                            </p>
                            <a href="{{ route('stream.detail', ['stream' => $stream->slug]) }}" class="btn btn-primary">{{ trans('stream.see') }}</a>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="d-flex justify-content-between">
                                <span>{{ $stream->postTimeAgo }}</span>
                                <span>{{ trans('stream.clicked', ['click' => $stream->clicks]) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="jumbotron mt-5">
        <h1 class="display-4">Artist Platform</h1>
        <p class="lead">{{ config('app.description') }}</p>
        <hr class="my-4">
        <a href="{{ route('register', ['provider' => 'facebook']) }}" class="btn btn-primary btn-lg">Facebook</a>
        <a href="{{ route('register', ['provider' => 'twitter']) }}" class="btn btn-primary btn-lg">Twitter</a>
        <hr class="my-4">
        <p>To learn more how this platform work we suggest to visit wiki pages.</p>
        <a class="btn btn-secondary btn-lg" href="#" role="button">Learn more</a>
    </div>
@endsection
