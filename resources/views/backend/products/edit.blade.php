@extends('backend.layouts.main')
@section('title', 'Products')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cập nhật sản phẩm</h1>
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

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/product/update/$product->id") }}">
        
        @csrf

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Category_ID">Category:</label>
                    <select class="custom-select" name="Category_ID" id="Category_ID">
                        <option value="">Choose...</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if( $category->id== $product->Category_ID) selected @endif>
                        {{ $category->Category_Name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Product_Name">Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" class="form-control" value="{{ $product->Product_Name }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="Product_Price">Price:</label>
                    <input type="text" name="Product_Price" id="Product_Price" class="form-control" value="{{ $product->Product_Price }}">
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
                    <select class="custom-select" name="Product_AvailableStatus" id="Product_AvailableStatus">
                        <option value="0" @if( $product->Product_AvailableStatus == "0") selected @endif>Chưa mở bán</option>
                        <option value="1" @if( $product->Product_AvailableStatus == "1") selected @endif>Sắp mở bán</option>
                        <option value="2" @if( $product->Product_AvailableStatus == "2") selected @endif>Đang bán</option>
                        <option value="3" @if( $product->Product_AvailableStatus == "3") selected @endif>Tạm ngưng bán</option>
                        <option value="4" @if( $product->Product_AvailableStatus == "4") selected @endif>Đã ngưng bán</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Product_SystemStatus">System Status:&nbsp</label>
                        @if($product->Product_SystemStatus == 1) <span style="color:	#0000cd"><i class="fas fa-lock-open"></i> Mở khóa</span> @endif
                        @if($product->Product_SystemStatus == 0) <span style="color:	#cd0000"><i class="fas fa-lock"></i> Đang khóa</span> @endif
                    <select class="custom-select" name="Product_SystemStatus" id="Product_SystemStatus">
                        <option value="1" @if( $product->Product_SystemStatus == "1") selected @endif>Mở khóa</option>
                        <option value="0" @if( $product->Product_SystemStatus == "0") selected @endif>Đang khóa</option>
                    </select>
                </div>
            </div>
        </div>
        

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="Product_Img">Image:</label>
                    <input type="file" name="Product_Img" class="form-control" id="Product_Img">

                    <div>
                        <?php $product->Product_Img = str_replace("public/", "", $product->Product_Img); ?>
                        <img alt=".img" src="{{ asset("storage/$product->Product_Img") }}" style="width: 200px; height: auto" />
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="Product_Description">Description:</label>
            <textarea name="Product_Description" class="form-control" rows="5" id="Product_Description">{{ $product->Product_Description }}</textarea>
        </div>


        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ url("/backend/product/info/$product->id") }}" class="btn btn-info">Info</a>
        <a href="{{ url("/backend/product/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection