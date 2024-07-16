@extends('layouts.app')

@section('content')
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="text-center mb-4">
                <a href="{{ route('posts.create') }}" class="btn btn-success">Add Blog</a>
            </div>
            @foreach ($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{$post->title}}</h5>
                            <p class="card-text">{{$post->content}}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">Posted on {{ $post->created_at->format('M d, Y') }}</small>
                            @if ($post->comments_count)
                                <small class="text-muted"> {{ $post->comments_count}} Comments</small>
                            @else
                                <small class="text-muted"> No Comments Yet </small>
                            @endif
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm ml-auto">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
