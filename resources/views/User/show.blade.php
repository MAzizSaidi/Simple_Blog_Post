@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>

        <!-- Display the user's current avatar -->
        <div class="mb-4">
            <img src="#" alt="Avatar" class="img-thumbnail" style="width: 150px; height: 150px;">
        </div>

        <!-- Display user's name -->
        <div class="mb-3">
            <h2>{{ $user->name }}</h2>
        </div>

        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit Profile</a>
    </div>
@endsection
