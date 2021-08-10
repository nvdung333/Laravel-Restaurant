@extends('backend.layouts.main')
@section('title', 'Restaurants')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách cơ sở, chi nhánh</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div style="padding-bottom: 10px">
        <a href="{{ url("/backend/restaurant/create") }}" class="btn btn-primary">Tạo mới</a>
        <a href="{{ url("/backend/restaurant/index") }}" class="btn btn-success">Refresh</a>
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
            <div class="col-md-4">
                <div class="form-group">
                    <label for="whereArea">Theo khu vực...</label>
                    <select name="whereArea" id="whereArea" class="custom-select">
                        <option value="">Choose...</option>
                        @foreach($areas as $area)
                        <option value="{{$area}}" {{ $whereArea == $area ? "selected" : "" }}>{{$area}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="whereOpenStatus">Trạng thái đóng/mở...</label>
                    <select name="whereOpenStatus" id="whereOpenStatus" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="0" {{ $whereOpenStatus == "0" ? "selected" : "" }}>Sắp khai trương</option>
                        <option value="1" {{ $whereOpenStatus == "1" ? "selected" : "" }}>Đang hoạt động</option>
                        <option value="2" {{ $whereOpenStatus == "2" ? "selected" : "" }}>Tạm ngưng hoạt động</option>
                        <option value="3" {{ $whereOpenStatus == "3" ? "selected" : "" }}>Đã đóng vĩnh viễn</option>
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

            <div class="col-md-1">
                <div class="form-group">
                    <label for="">Filter</label>
                    <div><button class="btn" style="background: #5a5c69; color: white;"><i class="fas fa-search"></i></button></div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th></th>
                <th>Name</th>
                <th>Address</th>
                <th>Area</th>
                <th>Phone</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($restaurants) && !empty($restaurants))
                @foreach($restaurants as $restaurant)
                <tr>
                    <th>{{ $restaurant->id }}</th>
                    <td style="text-align: center">
                        @if($restaurant->Restaurant_SystemStatus == 1)
                            <span style="color:	#0000cd"><i class="fas fa-lock-open"></i></span>
                        @endif
                        @if($restaurant->Restaurant_SystemStatus == 0)
                            <span style="color:	#cd0000"><i class="fas fa-lock"></i></span>
                        @endif
                    </td>
                    <td>
                        {{ $restaurant->Restaurant_Name }}
                        <div>
                            @if($restaurant->Restaurant_OpenStatus == 0)
                                <span style="color:white; background: #ffc125">&nbspSắp khai trương&nbsp</span>
                            @endif
                            @if($restaurant->Restaurant_OpenStatus == 1)
                                <span style="color:white; background: #008b00">&nbspĐang hoạt động&nbsp</span>
                            @endif
                            @if($restaurant->Restaurant_OpenStatus == 2)
                                <span style="color:white; background: #8b2323">&nbspTạm ngưng hoạt động&nbsp</span>
                            @endif
                            @if($restaurant->Restaurant_OpenStatus == 3)
                                <span style="color:white; background: #999999">&nbspĐã đóng vĩnh viễn&nbsp</span>
                            @endif
                        </div>
                    </td>
                    <td>{{ $restaurant->Restaurant_Address }}</td>
                    <td>{{ $restaurant->Restaurant_Area }}</td>
                    <td>{{ $restaurant->Restaurant_Phone }}</td>
                    <td>
                        <a href="{{ url("/backend/restaurant/info/$restaurant->id") }}" class="btn btn-info">Info</a>
                        <a href="{{ url("/backend/restaurant/edit/$restaurant->id") }}" class="btn btn-warning">Edit</a>
                        <a href="{{ url("/backend/restaurant/delete/$restaurant->id") }}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                @endforeach
            @else
                Chưa có bản ghi nào trong bảng này
            @endif
        </tbody>
    </table>

    {{ $restaurants->links("pagination::bootstrap-4") }}

@endsection