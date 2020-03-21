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
                <li class="nav-item dropdown">
                    @auth('web-artists')
                        <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ auth('web-artists')->user()->avatar }}" class="img-profile mr-1" alt="{{ auth('web-artists')->user()->realName }}">
                            {{ auth('web-artists')->user()->realName }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">{{ trans('profile.title') }}</a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('home.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item" href="#">{{ trans('profile.logout') }}</button>
                            </form>
                        </div>
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
