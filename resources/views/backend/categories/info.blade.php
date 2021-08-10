@extends('backend.layouts.main')
@section('title', 'Categories')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thông tin chi tiết danh mục hàng hóa</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>
    
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="padding-bottom: 10px">
        <a href="{{ url("/backend/category/index") }}" class="btn btn-secondary">Trở về</a>
        <a href="{{ url("/backend/category/info/$category->id") }}" class="btn btn-success">Refresh</a>
    </div>

    <form enctype="multipart/form-data">

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Category_Name">Name:</label>
                    <input type="text" name="Category_Name" id="Category_Name" class="form-control" value="{{ $category->Category_Name }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ $category->slug }}" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Category_Img">Image:</label>
            <br>
            <?php $category->Category_Img = str_replace("public/", "", $category->Category_Img); ?>
            <img alt=".img" src="{{ asset("storage/$category->Category_Img") }}" style="width: 200px; height: auto" />
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Category_Description">Description:</label>
                    <textarea name="Category_Description" class="form-control" rows="5" id="Category_Description" readonly>{{ $category->Category_Description }}</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Category_Parent_ID">Parent Category:</label>
                    @foreach($parentcategories as $parentcategory)
                        @if($parentcategory->id == $category->Category_Parent_ID)
                        <input type="text" name="Category_Parent_ID" id="Category_Parent_ID" class="form-control" value="{{ $parentcategory->Category_Name }}" readonly>
                        @endif
                    @endforeach
                    @if($category->Category_Parent_ID == "")
                        <input type="text" name="Category_Parent_ID" id="Category_Parent_ID" class="form-control" value="" readonly>
                    @endif
                </div>
            </div>
        </div>

        <label>Created at:&nbsp</label><span>{{$category->created_at}}</span><br>
        <label>Updated at:&nbsp</label><span>{{$category->updated_at}}</span><br>
        <label>Created user:&nbsp</label>@foreach($users as $user) @if($user->id == $category->created_user) <span>{{$user->User_FullName}}</span> @endif @endforeach <br>
        <label>Modified user:&nbsp</label>@foreach($users as $user) @if($user->id == $category->modified_user) <span>{{$user->User_FullName}}</span> @endif @endforeach <br>

        <a href="{{ url("/backend/category/edit/$category->id") }}" class="btn btn-warning">Edit</a>
        <a href="{{ url("/backend/category/delete/$category->id") }}" class="btn btn-danger">Delete</a>
    </form>
@endsection
