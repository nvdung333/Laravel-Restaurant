@extends('backend.layouts.main')
@section('title', 'Restaurants')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Xóa cơ sở, chi nhánh</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/restaurant/destroy/$restaurant->id") }}">
        
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID:</label>
                    <input type="text" name="id" id="id" class="form-control" value="{{ $restaurant->id }}" readonly>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Name">Name:</label>
                    <input type="text" name="Restaurant_Name" id="Restaurant_Name" class="form-control" value="{{ $restaurant->Restaurant_Name }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Area">Area:</label>
                    <input type="text" name="Restaurant_Area" id="Restaurant_Area" class="form-control" value="{{ $restaurant->Restaurant_Area }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Address">Address:</label>
                    <input type="text" name="Restaurant_Address" id="Restaurant_Address" class="form-control" value="{{ $restaurant->Restaurant_Address }}" readonly>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-danger">Destroy</button>
        <a href="{{ url("/backend/restaurant/info/$restaurant->id") }}" class="btn btn-info">Info</a>
        <a href="{{ url("/backend/restaurant/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection
