@extends("layouts.main")

@section("body")
    <h1>{{ $stream->title }} by {{ $stream->artist->name }}</h1>
@endsection
