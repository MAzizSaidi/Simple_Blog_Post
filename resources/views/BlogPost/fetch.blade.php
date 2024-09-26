@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="text-center mb-4 col-12">
                <a href="{{ route('posts.create') }}" class="btn btn-success">{{ __("Add Blog") }}</a>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card" style="width: 25rem;">

                    <div class="card-body">
                        <h5 class="card-title">{{ __("Most Commented Blogpost !") }}</h5>
                        <p class="card-text">{{ __("Discover the most talked-about blog posts that are capturing everyone's attention.") }}</p>
                    </div>

                    <div class="list-group list-group-flush">
                        @foreach($mostCommented as $post)
                            <div class="list-group-item mb-2">
                               <p>{{ $post->title }}</p>
                                <small class="text-muted">{{ $post->comments_count }} {{ __("Comments") }}</small>
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-primary btn-sm float-end">{{ __("View") }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card mt-4" style="width: 25rem;">

                            <div class="card-body">
                                <h5 class="card-title">{{ __("Most Active Users !") }}</h5>
                                <p class="card-text">{{ __("Discover the most active users that are capturing everyone's attention.") }}</p>
                            </div>

                            <div class="list-group list-group-flush">
                                @foreach($activeUser as $user)
                                    <div class="list-group-item mb-2">
                                        <p>{{ $user->name }}</p>
                                        <small class="text-muted float-end">{{ $user->blogpost_count }} {{ __("Blogs") }}</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
              </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card mt-4" style="width: 25rem;">

                            <div class="card-body">
                                <h5 class="card-title">{{ __("Most Active Users Last Two Months !") }}</h5>
                                <p class="card-text">{{ __("Discover the most active users that are capturing everyone's attention in the last 2 months.") }}</p>
                            </div>

                            <div class="list-group list-group-flush">
                                @foreach($MostActiveUserLastMonth as $user)
                                    <div class="list-group-item mb-2">
                                        <p>{{ $user->name }}</p>
                                        <small class="text-muted float-end">{{ $user->blogpost_count }} {{ __("Blogs") }}</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
             </div>
            <div class="col-md-8">
                <div class="row">
                    @foreach ($posts as $post)
                        <div class="col-md-12 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    @if ($post->trashed())
                                        <del>
                                    @endif
                                    <h5 class="card-title">{{ $post->title }}</h5>
                                                @if ($post->tags->count())
                                                @component('components.tag',['tags' => $post->tags]) @endcomponent
                                                @endif
                                        @if ($post->trashed())
                                            </del>
                                        @endif
                                    <p class="card-text">{{ $post->content }}</p>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center">

                                    <small class="text-muted">{{ __("Posted on") }} {{ $post->created_at->format('M d, Y') }}</small>

                                    <small class="text-muted">{{ __("By") }}
                                        <a href="{{route('users.show',$post->user)}}">{{ $post->user->name }}</a>
                                    </small>


                                        <small class="text-muted">{{ trans_choice('messages.comments' , $post->comments_count) }}</small>


                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm ml-auto">{{ __("View") }}</a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
