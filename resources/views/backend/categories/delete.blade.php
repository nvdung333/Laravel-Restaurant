@extends('backend.layouts.main')
@section('title', 'Categories')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Xóa danh mục hàng hóa</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/category/destroy/$category->id") }}">
        
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id">ID:</label>
                    <input type="text" name="id" id="id" class="form-control" value="{{ $category->id }}" readonly>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Category_Name">Name:</label>
                    <input type="text" name="Category_Name" id="Category_Name" class="form-control" value="{{ $category->Category_Name }}" readonly>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-danger">Destroy</button>
        <a href="{{ url("/backend/category/index") }}" class="btn btn-secondary">Trở về</a>

    </form>
@endsection