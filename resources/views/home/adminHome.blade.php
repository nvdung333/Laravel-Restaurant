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

                    {{ __('Hello Admin!') }}
                </div>
            </div>
            <a class="btn btn-primary" href="{{ url("/home") }}" role="button">Normal Home</a>
            <a class="btn btn-primary" href="{{ url("/backend/user/admin") }}" role="button">Admin Setting</a>
            <a class="btn btn-primary" href="{{ url("/backend/user/srole") }}" role="button">Role Setting</a>
        </div>
    </div>
</div>
@endsection
