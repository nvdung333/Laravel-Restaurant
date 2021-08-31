@extends('frontend.layouts.main')
@section('title', "Payment")


@section('content')
    
    <form method="POST" action="{{ url('payment/checkout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger">ORDER</button>
    </form>
    
@endsection
