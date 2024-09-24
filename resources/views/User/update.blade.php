@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{__('Update Profile')}}</h1>

        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Avatar Upload -->
                <div class="col-md-4 mb-4">
                    <!-- Display the user's current avatar -->
                    <div class="mb-3">
                        <img src="#" alt="Avatar" class="img-thumbnail avatar" >
                    </div>
                    <!-- Avatar upload field -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">{{__('Change Avatar')}}</label>
                        <input type="file" class="form-control" id="avatar" name="{{__('Avatar')}}">
                        @error('avatar')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Name Field -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">{{__('Name')}}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>

                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">{{__('Update Profile')}}</button>
                </div>
            </div>
        </form>
    </div>


@endsection
