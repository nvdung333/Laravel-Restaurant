@extends('backend.layouts.main')
@section('title', 'Categories')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm thể loại hàng hóa</h1>
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

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/category/store") }}">
        
        @csrf

        <div class="form-group">
            <label for="Category_Name">Name:</label>
            <input type="text" name="Category_Name" id="Category_Name" class="form-control" value="{{ old('Category_Name', "") }}">
        </div>

        <div class="form-group">
            <label for="Category_Img">Image:</label>
            <input type="file" name="Category_Img" class="form-control" id="Category_Img">
        </div>

        <div class="form-group">
            <label for="Category_Description">Description:</label>
            <textarea name="Category_Description" class="form-control" rows="5" id="Category_Description">{{ old('Category_Description', "") }}</textarea>
        </div>

        <div class="form-group">
            <label for="Category_Parent_ID">Parent Category:</label>
            <select class="custom-select" name="Category_Parent_ID" id="Category_Parent_ID">
                <option value="">Choose...</option>
                @foreach($parentcategories as $parentcategory)
                <option value="{{ $parentcategory->id }}" {{ old('Category_Parent_ID') == "$parentcategory->id" ? "selected" : "" }}>{{ $parentcategory->Category_Name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ url("/backend/category/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection