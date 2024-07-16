@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $post->title }}</h5>
                        <small class="text-muted">Posted on {{ $post->created_at->format('M d, Y') }}</small>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning mr-2">Update</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mr-2">Delete</button>
                            </form>
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
                    <div class="card-header ">
                        @forelse($post->comments as $comment)
                            <div class=" d-flex justify-content-between ">
                                <p>{{$comment->content}}</p>
                                <small class="text-muted">added at {{ $comment->created_at->diffForHumans()}}</small>
                            </div>
                        @empty
                            <small>No comment added yet .. add your vision</small>
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
