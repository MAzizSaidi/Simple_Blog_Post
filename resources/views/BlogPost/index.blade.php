@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card"
                     @if(isset($post->images->path))
                         style="background-image: url('{{ asset( $post->images->path) }}'); background-size: cover; background-position: center;"
                     @else
                         style="color: black;"
                    @endif>
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start">
                        <div>
                            <h5>{{ $post->title }}</h5>
                            <small style="color: white;">Posted on {{ $post->created_at->format('M d, Y') }}</small>
                        @if ((new \Carbon\Carbon())->diffInSeconds($post->created_at) <= 10)
                                @component('components.badge')
                                    Just added {{ $post->created_at->diffForHumans() }}
                                @endcomponent
                            @endif
                        </div>
                        <div class="mb-3 mt-md-0">
                            @component('components.badge', ['conter' => $conter])@endcomponent
                            @component('components.tag', ['tags' => $post->tags]) @endcomponent
                        </div>
                    </div>

                    <div class="card-body">
                        @if(!isset($post->images->path))
                            <p class="card-text">{{ $post->content }}</p>

                        @endif
                    </div>

                    <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-start">
                        <div>
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning mb-2 mb-md-0">Update</a>
                            @endcan
                            @if($post->trashed())
                                <p class="mt-4">This post is actually deleted. Do you want to restore it?</p>
                                @can('restore', $post)
                                    <form action="{{ route('posts.restore', $post) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-info mb-2 mb-md-0">Restore</button>
                                    </form>
                                @endcan
                            @endif
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mb-2 mb-md-0">Delete</button>
                                </form>
                            @endcan
                            <button id="commentBtn" class="btn btn-primary mb-2 mb-md-0">Comment</button>
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
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Blog</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5>Comments</h5>
                        @forelse($post->comments as $comment)
                            <div class="media mb-3">
                                <img src="https://via.placeholder.com/50" class="me-3 rounded-circle" alt="User avatar">
                                <div class="media-body">
                                    <h6 class="mt-0">{{ $comment->user->name }}</h6>
                                    <p>{{ $comment->content }}</p>
                                    <small style="color: white" >Added {{ $comment->created_at->diffForHumans() }}</small>
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
