@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>

        <!-- Display the user's current avatar -->
        <div class="mb-4">

            @if(isset($user->image))
                <img src="{{ asset($user->image->path) }}" alt="Avatar" class="img-thumbnail rounded-circle avatar">
                
            @endif

        </div>

        <!-- Display user's name -->
        <div class="mb-3">
            <h2>{{ $user->name }}</h2>
        </div>

        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Go to Posts!</a>
    </div>
@endsection
