@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5>{{ $post->title }}</h5>
                            <small class="text-muted">Posted on {{ $post->created_at->format('M d, Y') }}</small>
                            @if ((new \Carbon\Carbon())->diffInSeconds($post->created_at) <= 10)
                                @component('Components.badge')
                                    Just added {{ $post->created_at->diffForHumans() }}
                                @endcomponent
                            @endif
                        </div>
                        <div>
                            <p class="mb-0">Currently seen by {{$conter}} Users</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning mr-2">Update</a>
                            @endcan
                            @if($post->trashed())
                                <p class="mt-4">this post is actually deleted. do you want to restore it?</p>
                                    @can('restore', $post)
                                        <form action="{{ route('posts.restore', $post) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-info mr-2">Restore</button>
                                        </form>
                                    @endcan
                            @endif
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mr-2">Delete</button>
                                </form>
                            @endcan

                            <button id="commentBtn" class="btn btn-primary mr-2">Comment</button>
                            <div id="commentField" style="display: none;">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="blog_post_id" value="{{ $post->id }}">
                                    <div class="form-group mt-2">
                                        <textarea class="form-control" name="content" rows="3" placeholder="Write your comment here..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Blog</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5>Comments</h5>
                        @forelse($post->comments as $comment)
                            <div class="media mb-3">
                                <img src="https://via.placeholder.com/50" class="mr-3 rounded-circle" alt="User avatar">
                                <div class="media-body">
                                    <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                    <p>{{ $comment->content }}</p>
                                    <small class="text-muted">added {{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @empty
                            <small>No comments yet. Add your thoughts below.</small>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('commentBtn').addEventListener('click', function() {
            this.style.display = 'none';
            document.getElementById('commentField').style.display = 'block';
        });
    </script>
@endsection
