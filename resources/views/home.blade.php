@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
            <a class="btn btn-secondary" href="{{ url("/home/admin") }}" role="button">Admin Home</a>
            <a class="btn btn-secondary" href="{{ url("/home/mod") }}" role="button">Moderator Home</a>
            <a class="btn btn-secondary" href="{{ url("/home/user") }}" role="button">User Home</a>
        </div>
    </div>
</div>
@endsection
