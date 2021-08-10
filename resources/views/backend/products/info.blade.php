@extends('backend.layouts.main')
@section('title', 'Products')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thông tin chi tiết sản phẩm</h1>
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
        <a href="{{ url("/backend/product/index") }}" class="btn btn-secondary">Trở về</a>
        <a href="{{ url("/backend/product/info/$product->id") }}" class="btn btn-success">Refresh</a>
    </div>

    <form enctype="multipart/form-data">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Category_ID">Category:</label>
                    @foreach($categories as $category)
                        @if($category->id == $product->Category_ID)
                        <input type="text" name="Category_ID" id="Category_ID" class="form-control" value="{{ $category->Category_Name }}" readonly>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Product_Name">Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" class="form-control" value="{{ $product->Product_Name }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Product_Price">Price:</label>
                    <input type="text" name="Product_Price" id="Product_Price" class="form-control" value="{{ $product->Product_Price }}" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Product_AvailableStatus">Available Status:&nbsp</label>
                    @if($product->Product_AvailableStatus == 0) <span style="color:white; background: #00c5cd">&nbspChưa mở bán&nbsp</span> @endif
                    @if($product->Product_AvailableStatus == 1) <span style="color:white; background: #ffc125">&nbspSắp mở bán&nbsp</span> @endif
                    @if($product->Product_AvailableStatus == 2) <span style="color:white; background: #008b00">&nbspĐang bán&nbsp</span> @endif
                    @if($product->Product_AvailableStatus == 3) <span style="color:white; background: #8b2323">&nbspTạm ngưng bán&nbsp</span> @endif
                    @if($product->Product_AvailableStatus == 4) <span style="color:white; background: #999999">&nbspĐã ngưng bán&nbsp</span> @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Product_SystemStatus">System Status:&nbsp</label>
                    @if($product->Product_SystemStatus == 1) <span style="color:	#0000cd"><i class="fas fa-lock-open"></i> Mở khóa</span> @endif
                    @if($product->Product_SystemStatus == 0) <span style="color:	#cd0000"><i class="fas fa-lock"></i> Đang khóa</span> @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Product_Img">Image:</label>
            <br>
            <?php $product->Product_Img = str_replace("public/", "", $product->Product_Img); ?>
            <img alt=".img" src="{{ asset("storage/$product->Product_Img") }}" style="width: 200px; height: auto" />
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Product_Description">Description:</label>
                    <textarea name="Product_Description" class="form-control" rows="5" id="Product_Description" readonly>{{ $product->Product_Description }}</textarea>
                </div>
            </div>
        </div>

        <label>Created at:&nbsp</label><span>{{$product->created_at}}</span><br>
        <label>Updated at:&nbsp</label><span>{{$product->updated_at}}</span><br>
        <label>Created user:&nbsp</label>@foreach($users as $user) @if($user->id == $product->created_user) <span>{{$user->User_FullName}}</span> @endif @endforeach <br>
        <label>Modified user:&nbsp</label>@foreach($users as $user) @if($user->id == $product->modified_user) <span>{{$user->User_FullName}}</span> @endif @endforeach <br>

        <a href="{{ url("/backend/product/edit/$product->id") }}" class="btn btn-warning">Edit</a>
        <a href="{{ url("/backend/product/delete/$product->id") }}" class="btn btn-danger">Delete</a>
    </form>
@endsection
