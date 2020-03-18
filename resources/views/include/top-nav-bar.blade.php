<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home.index') }}">
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('home.index') }}">
                        {{ trans('nav.home') }}
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        {{ trans('nav.about-us') }}
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    @auth('web-artists')
                        <a href="#" class="nav-link">
                            {{ auth('web-artists')->user()->realName }}
                        </a>
                    @endauth

                    @guest('web-artists')
                    <a href="{{ route('home.login') }}" class="nav-link">
                        {{ trans('nav.log-in') }}
                    </a>
                    @endguest
                    
                </li>
            </ul>
        </div>
    </div>
</nav>
