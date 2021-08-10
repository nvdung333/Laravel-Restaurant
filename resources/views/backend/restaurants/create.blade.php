@extends('backend.layouts.main')
@section('title', 'Restaurants')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm cơ sở, chi nhánh</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/restaurant/store") }}">
        
        @csrf

        <div class="form-group">
            <label for="Restaurant_Name">Name:</label>
            <input type="text" name="Restaurant_Name" id="Restaurant_Name" class="form-control" value="{{ old('Restaurant_Name', "") }}">
        </div>

        <div class="form-group">
            <label for="Restaurant_Address">Address:</label>
            <input type="text" name="Restaurant_Address" id="Restaurant_Address" class="form-control" value="{{ old('Restaurant_Address', "") }}">
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Area">Area:</label>
                    <input type="text" name="Restaurant_Area" id="Restaurant_Area" class="form-control" value="{{ old('Restaurant_Area', "") }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Phone">Phone Number:</label>
                    <input type="text" name="Restaurant_Phone" id="Restaurant_Phone" class="form-control" value="{{ old('Restaurant_Phone', "") }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Restaurant_Description">Description:</label>
            <textarea name="Restaurant_Description" class="form-control" rows="5" id="Restaurant_Description">{{ old('Restaurant_Description', "") }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ url("/backend/restaurant/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection
