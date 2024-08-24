@extends('layout.navbar')

@section('title', __('friend.title'))
@section('activeFriend', 'active')

@section('content')

    <div class="container">
        <h2>{{ __('friend.friend_list') }}</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container">
            <div class="row">
                @foreach ($dataFriend as $user)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $user->profile_path) }}" alt="{{ $user->name }}'s profile"
                                class="card-img-top img-fluid" style="object-fit: cover; height: 250px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <p class="card-text">{{ __('friend.hobby', ['hobby' => $user->hobby]) }}</p>
                                <a href="https://meet.google.com/new" target="_blank"
                                    class="btn btn-primary mt-auto w-100">{{ __('friend.message') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
