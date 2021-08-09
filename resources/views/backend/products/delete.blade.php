@extends('backend.layouts.main')
@section('title', 'Products')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Xóa sản phẩm</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/product/destroy/$product->id") }}">
        
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID:</label>
                    <input type="text" name="id" id="id" class="form-control" value="{{ $product->id }}" readonly>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Product_Name">Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" class="form-control" value="{{ $product->Product_Name }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">                
                <div class="form-group">
                    <?php $product->Product_Img = str_replace("public/", "", $product->Product_Img); ?>
                    <img alt=".img" src="{{ asset("storage/$product->Product_Img") }}" style="width: 250px; height: auto" />
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-danger">Destroy</button>
        <a href="{{ url("/backend/product/details/$product->id") }}" class="btn btn-info">Details</a>
        <a href="{{ url("/backend/product/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection