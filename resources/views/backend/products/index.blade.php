@extends('backend.layouts.main')
@section('title', 'Products')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách các sản phẩm</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div style="padding-bottom: 10px">
        <a href="{{ url("/backend/product/create") }}" class="btn btn-primary">Tạo mới</a>
        <a href="{{ url("/backend/product/index") }}" class="btn btn-success">Refresh</a>
    </div>

    <form name="searchfilter" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" style="border: 1px solid grey; border-radius: 5px; padding: 10px;">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="keyword">Tìm kiếm</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search for..." value="{{ $search_keyword }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="whereCategory">Theo danh mục con...</label>
                    <select name="whereCategory" id="whereCategory" class="custom-select">
                        <option value="">Choose...</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" {{ $whereCategory == $category->id ? "selected" : "" }}>{{$category->Category_Name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="whereAvailableStatus">Trạng thái bán...</label>
                    <select name="whereAvailableStatus" id="whereAvailableStatus" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="0" {{ $whereAvailableStatus == "0" ? "selected" : "" }}>Chưa mở bán</option>
                        <option value="1" {{ $whereAvailableStatus == "1" ? "selected" : "" }}>Sắp mở bán</option>
                        <option value="2" {{ $whereAvailableStatus == "2" ? "selected" : "" }}>Đang bán</option>
                        <option value="3" {{ $whereAvailableStatus == "3" ? "selected" : "" }}>Tạm ngưng bán</option>
                        <option value="4" {{ $whereAvailableStatus == "4" ? "selected" : "" }}>Đã ngưng bán</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="whereSystemStatus">Trạng thái khóa...</label>
                    <select name="whereSystemStatus" id="whereSystemStatus" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="1" {{ $whereSystemStatus == "1" ? "selected" : "" }}>Mở khóa</option>
                        <option value="0" {{ $whereSystemStatus == "0" ? "selected" : "" }}>Đang khóa</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="orderdir">Sắp xếp giá...</label>
                    <select name="orderdir" id="orderby" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="ASC" {{ $order_dir == "ASC" ? "selected" : "" }}>Tăng dần</option>
                        <option value="DESC" {{ $order_dir == "DESC" ? "selected" : "" }}>Giảm dần</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label for="">Filter</label>
                    <div><button class="btn" style="background: #5a5c69; color: white;"><i class="fas fa-search"></i></button></div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th></th>
                <th>Image</th>
                <th>Product_Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($products) && !empty($products))
                @foreach($products as $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <td style="text-align: center">
                        @if($product->Product_SystemStatus == 1)
                            <span style="color:	#0000cd"><i class="fas fa-lock-open"></i></span>
                        @endif
                        @if($product->Product_SystemStatus == 0)
                            <span style="color:	#cd0000"><i class="fas fa-lock"></i></span>
                        @endif
                    </td>
                    <td>
                        <?php $product->Product_Img = str_replace("public/", "", $product->Product_Img); ?>
                        <img alt=".img" src="{{ asset("storage/$product->Product_Img") }}" style="width: 52px; height: auto" />
                    </td>
                    <td>
                        {{ $product->Product_Name }}
                        <div>
                            @if($product->Product_AvailableStatus == 0)
                                <span style="color:white; background: #00c5cd">&nbspChưa mở bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 1)
                                <span style="color:white; background: #ffc125">&nbspSắp mở bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 2)
                                <span style="color:white; background: #008b00">&nbspĐang bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 3)
                                <span style="color:white; background: #8b2323">&nbspTạm ngưng bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 4)
                                <span style="color:white; background: #999999">&nbspĐã ngưng bán&nbsp</span>
                            @endif
                        </div>

                    </td>
                    <td>
                        @foreach($categoryofproducts as $categoryofproduct)
                            @if($categoryofproduct->t1_id == $product->id)
                                {{ $categoryofproduct->t2_name }}
                            @endif
                        @endforeach
                    </td>
                    <td>{{ $product->Product_Price }}</td>
                    <td>
                        <a href="{{ url("/backend/product/info/$product->id") }}" class="btn btn-info">Info</a>
                        <a href="{{ url("/backend/product/edit/$product->id") }}" class="btn btn-warning">Edit</a>
                        <a href="{{ url("/backend/product/delete/$product->id") }}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            @else
                Chưa có bản ghi nào trong bảng này
            @endif
        </tbody>
    </table>

    {{ $products->links("pagination::bootstrap-4") }}

@endsection