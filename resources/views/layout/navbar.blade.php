<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/nav.css">
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="#"> <span class="logo-1">Connect</span>Friend</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link @yield('activeHome')" href="{{ route('user.index') }}">
                            {{ __('navbar.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('activeRequest')" href="{{ route('friend-request.index') }}">
                            {{ __('navbar.requests') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('activeFriend')" href="{{ route('friend.index') }}">
                            {{ __('navbar.friends_list') }}
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        @if (App::getLocale() == 'en')
                            <a class="nav-link" href="{{ url('locale/id') }}">
                                {{ __('navbar.switch_language') }}
                            </a>
                        @else
                            <a class="nav-link" href="{{ url('locale/en') }}">
                                {{ __('navbar.switch_language') }}
                            </a>
                        @endif
                    </li>
                </ul>
                @if (Auth::check())
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('navbar.logout') }}</button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="btn btn-primary">{{ __('navbar.login') }}</a>
                    <a href="{{ url('/register') }}" class="btn btn-secondary">{{ __('navbar.register') }}</a>
                @endif
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('script')
</body>

</html>
