@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="display-4 text-center mb-4">Profile</h1>

        <!-- Display the user's current avatar -->
        <div class="text-center mb-4">
            @if(isset($user->image))
                <img src="{{ asset($user->image->path) }}" alt="Avatar" class="img-thumbnail rounded-circle avatar shadow-lg" style="width: 150px; height: 150px;">
            @endif
        </div>

        <!-- Display user's name -->
        <div class="text-center mb-4">
            <h2 class="text-uppercase">{{ $user->name }}</h2>
        </div>

        <div class="text-center mb-5">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-lg mx-2">Edit Profile</a>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg mx-2">Go to Posts!</a>
            <button id="commentBtn" class="btn btn-outline-primary btn-lg mx-2">Comment</button>
        </div>

        <div id="commentField" class="mb-5" style="display: none;">
            <form action="{{ route('users.comment.store') }}" method="POST" class="shadow-sm p-4 rounded bg-light">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3" placeholder="Write your comment here..."></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-3">Submit</button>
            </form>
        </div>

        @forelse($user->commentsOn as $comment)
            <div class="comment-block mb-4 p-4 border rounded bg-white shadow-sm">
                <div class="d-flex align-items-start mb-2">
                    @if($comment->user->image)
                        <img src="{{ asset($comment->user->image->path) }}" class="img-thumbnail rounded-circle profile me-3 shadow" alt="User avatar" style="width: 50px; height: 50px;">
                    @endif
                    <div class="w-100">
                        <div class="d-flex justify-content-between mb-1">
                            <a href="{{ route('users.show', ['user' => $comment->user]) }}" class="text-primary text-decoration-none">
                                <h6 class="mt-0 mb-1 font-weight-bold">{{ $comment->user->name }}</h6>
                            </a>
                            <div>
                                @component('components.tag', ['tags' => $comment->tags]) @endcomponent
                            </div>
                        </div>
                        <p class="comment-content mb-1 text-secondary">{{ $comment->content }}</p>
                        <small class="text-muted">Added {{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">No comments yet. Add your thoughts below.</div>
        @endforelse
    </div>

    <script>
        document.getElementById('commentBtn').addEventListener('click', function() {
            this.style.display = 'none';
            document.getElementById('commentField').style.display = 'block';
        });
    </script>
@endsection
