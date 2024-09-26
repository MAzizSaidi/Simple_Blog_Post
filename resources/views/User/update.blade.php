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

                        <img id="avatarPreview" src="{{ $user->image ? asset($user->image->path) : '#' }}" alt="Avatar" class="img-thumbnail avatar" >

                    </div>
                    <!-- Avatar upload field -->
                    <div class="mb-3">
                        <label for="avatar" class="form-label">{{__('Change Avatar')}}</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" onchange="previewImage(event)">
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

    <script>
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const preview = document.getElementById('avatarPreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
