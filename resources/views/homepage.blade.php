<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <title>{{ config('app.name') }}</title>
</head>
<body>

    @include("include.top-nav-bar")

    <div class="jumbotron">
        <h1 class="display-4">Artist Platform</h1>
        <p class="lead">{{ config('app.description') }}</p>
        <hr class="my-4">
        <a href="{{ route('register', ['provider' => 'facebook']) }}" class="btn btn-primary btn-lg">Facebook</a>
        <a href="{{ route('register', ['provider' => 'twitter']) }}" class="btn btn-primary btn-lg">Twitter</a>
        <hr class="my-4">
        <p>To learn more how this platform work we suggest to visit wiki pages.</p>
        <a class="btn btn-secondary btn-lg" href="#" role="button">Learn more</a>
    </div>

</body>
</html>
