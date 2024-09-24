@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card d-flex flex-column align-items-center">
                    <div class="card-header w-100 text-center">{{ __('Dashboard') }}</div>
                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @elseif (session('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
                        <p> Using Php : {{__('messages.welcome')}} </p>
                        <p> Using JSON : {{__('Welcome to Laravel!')}} </p>
                        <p>{{ __('You are logged in!') }}</p>
                    </div>
                    <div class="card-footer w-100 text-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">{{__('Go to Posts!')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
