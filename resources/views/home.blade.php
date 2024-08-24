@extends('layout.navbar')

@section('title', __('home.friend_recommendation'))
@section('activeHome', 'active')

@section('styles')
<link rel="stylesheet" href="/home.css">
@endsection

@section('content')

<div class="container-fluid">
    <div class="header" style="margin: 1rem;">
        <div class="header-top d-flex">
            <div class="header-text">
                <h2>{{ __('home.greeting', ['name' => Auth::user()->name]) }}</h2>
                <p>{{ __('home.balance', ['coins' => Auth::user()->coins]) }}</p>
            </div>
            <div class="header-notif">
                <h2>{{ __('home.notifications') }}</h2>
                <div class="alert alert-info">
                    <ul class="list-unstyled mb-0">
                        @forelse (Auth::user()->notifications as $notification)
                            <li>
                                {{ $notification->data['message'] }}
                                <a href="{{ route('notifications.destroy', $notification->id) }}" class="btn btn-danger btn-sm ms-2"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $notification->id }}').submit();">
                                    <i class="icon-close"></i>
                                </a>

                                <form id="delete-form-{{ $notification->id }}"
                                    action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </li>
                        @empty
                            <li>{{ __('home.no_notifications') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('user.index') }}" class="mb-4 searchbar">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('home.search_placeholder') }}"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">{{ __('home.search_placeholder') }}</button>
                </div>
            </div>
        </form>

        <div class="hobby-filters">
            <div class="row">
                <div class="col-md-1">
                    <a href="{{ route('user.index', ['search' => request('search')]) }}" class="btn w-100 {{ !request('hobby') ? 'active-filter' : '' }}" data-hobby="all">
                        {{ __('home.all') }}
                    </a>
                </div>

                @foreach(['Basketball', 'Soccer', 'Running', 'Tech', 'Drawing', 'Chess', 'Volleyball', 'Studying', 'Writing', 'Reading'] as $hobby)
                    <div class="col-md-1">
                        <a href="{{ route('user.index', ['hobby' => $hobby, 'search' => request('search')]) }}"
                           class="btn w-100 {{ request('hobby') == $hobby ? 'active-filter' : '' }}"
                           data-hobby="{{ $hobby }}">
                            {{ $hobby }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="gender-filters">
            <div class="row">
                <div class="col-md-1">
                    <a href="{{ route('user.index', ['search' => request('search'), 'hobby' => request('hobby')]) }}" class="btn w-100 {{ !request('gender') ? 'active-filter' : '' }}" data-gender="all">
                        {{ __('home.all_genders') }}
                    </a>
                </div>

                @foreach(['Male', 'Female'] as $gender)
                    <div class="col-md-1">
                        <a href="{{ route('user.index', ['gender' => $gender, 'search' => request('search'), 'hobby' => request('hobby')]) }}"
                           class="btn w-100 {{ request('gender') == $gender ? 'active-filter' : '' }}"
                           data-gender="{{ $gender }}">
                            {{ __('home.' . strtolower($gender)) }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    <div class="container">
        <h2>{{ __('home.friend_recommendation') }}</h2>
        <div class="row">
            @foreach ($dataUser as $user)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card" style="margin: 1rem;">
                        <img src="{{ asset('storage/' . $user->profile_path) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">{{ __('home.hobby') }} : {{ $user->hobby }}</p>
                            <p class="card-text">{{ __('home.age') }} : {{ $user->age }}</p>
                            <p class="card-text">{{ __('home.gender') }} : {{ $user->gender }}</p>
                            <form method="POST" action="{{ route('friend-request.store')}}">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-primary w-100">{{ __('home.request_friend') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.hobby-filters .btn');
        const genderButtons = document.querySelectorAll('.gender-filters .btn');

        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                buttons.forEach(btn => btn.classList.remove('active-filter'));
                this.classList.add('active-filter');
                const selectedHobby = this.getAttribute('data-hobby');
                let url = new URL(this.href);
                if (selectedHobby === 'all') {
                    url.searchParams.delete('hobby');
                } else {
                    url.searchParams.set('hobby', selectedHobby);
                }
                window.location.href = url.toString();
            });
        });

        genderButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                genderButtons.forEach(btn => btn.classList.remove('active-filter'));
                this.classList.add('active-filter');
                const selectedGender = this.getAttribute('data-gender');
                let url = new URL(this.href);
                if (selectedGender === 'all') {
                    url.searchParams.delete('gender');
                } else {
                    url.searchParams.set('gender', selectedGender);
                }
                window.location.href = url.toString();
            });
        });
    });
</script>
@endsection
