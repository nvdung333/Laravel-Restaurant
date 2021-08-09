@extends('backend.layouts.main')
@section('title', 'Products')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm sản phẩm</h1>
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

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/product/store") }}">
        
        @csrf

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Category_ID">Category:</label>
                    <select class="custom-select" name="Category_ID" id="Category_ID">
                        <option value="">Choose...</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('Category_ID') == "$category->id" ? "selected" : "" }}>{{ $category->Category_Name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Product_Name">Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" class="form-control" value="{{ old('Product_Name', "") }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Product_Price">Price:</label>
                    <input type="text" name="Product_Price" id="Product_Price" class="form-control" value="{{ old('Product_Price', "") }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Product_Img">Image:</label>
            <input type="file" name="Product_Img" class="form-control" id="Product_Img">
        </div>

        <div class="form-group">
            <label for="Product_Description">Description:</label>
            <textarea name="Product_Description" class="form-control" rows="5" id="Product_Description">{{ old('Product_Description', "") }}</textarea>
        </div>



        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ url("/backend/product/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection