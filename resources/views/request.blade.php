@extends('layout.navbar')

@section('title', __('request.title'))
@section('activeRequest', 'active')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <h2>{{ __('request.friend_requests') }}</h2>
        <div class="row">
            @forelse ($friendRequests as $request)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $request->profile_path) }}" alt="{{ $request->name }}'s profile"
                            class="card-img-top img-fluid" style="object-fit: cover; height: 250px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $request->name }}</h5>
                            <p class="card-text">{{ $request->fields_of_work }}</p>
                            <form method="POST" action="{{ route('friend.accept') }}" class="mb-2">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $request->request_id }}">
                                <input type="hidden" name="friend_id" value="{{ $request->id }}">
                                <button type="submit" class="btn btn-primary w-100">{{ __('request.accept') }}</button>
                            </form>
                            <form method="POST" action="{{ route('friend-request.destroy', $request->request_id) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">{{ __('request.decline') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">{{ __('request.no_requests') }}</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
