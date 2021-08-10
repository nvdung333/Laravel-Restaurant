@extends('backend.layouts.main')
@section('title', 'Restaurants')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cập nhật cơ sở, chi nhánh</h1>
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

    <form method="post" enctype="multipart/form-data" action="{{ url("/backend/restaurant/update/$restaurant->id") }}">
        
        @csrf

        <div class="form-group">
            <label for="Restaurant_Name">Name:</label>
            <input type="text" name="Restaurant_Name" id="Restaurant_Name" class="form-control" value="{{ $restaurant->Restaurant_Name }}">
        </div>

        <div class="form-group">
            <label for="Restaurant_Address">Address:</label>
            <input type="text" name="Restaurant_Address" id="Restaurant_Address" class="form-control" value="{{ $restaurant->Restaurant_Address }}">
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Area">Area:</label>
                    <input type="text" name="Restaurant_Area" id="Restaurant_Area" class="form-control" value="{{ $restaurant->Restaurant_Area }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Phone">Phone Number:</label>
                    <input type="text" name="Restaurant_Phone" id="Restaurant_Phone" class="form-control" value="{{ $restaurant->Restaurant_Phone }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_OpenStatus">Open Status:&nbsp</label>
                        @if($restaurant->Restaurant_OpenStatus == 0) <span style="color:white; background: #ffc125">&nbspSắp khai trương&nbsp</span> @endif
                        @if($restaurant->Restaurant_OpenStatus == 1) <span style="color:white; background: #008b00">&nbspĐang hoạt động&nbsp</span> @endif
                        @if($restaurant->Restaurant_OpenStatus == 2) <span style="color:white; background: #8b2323">&nbspTạm ngưng hoạt động&nbsp</span> @endif
                        @if($restaurant->Restaurant_OpenStatus == 3) <span style="color:white; background: #999999">&nbspĐã đóng vĩnh viễn&nbsp</span> @endif
                    <select class="custom-select" name="Restaurant_OpenStatus" id="Restaurant_OpenStatus">
                        <option value="0" @if( $restaurant->Restaurant_OpenStatus == "0") selected @endif>Sắp khai trương</option>
                        <option value="1" @if( $restaurant->Restaurant_OpenStatus == "1") selected @endif>Đang hoạt động</option>
                        <option value="2" @if( $restaurant->Restaurant_OpenStatus == "2") selected @endif>Tạm ngưng hoạt động</option>
                        <option value="3" @if( $restaurant->Restaurant_OpenStatus == "3") selected @endif>Đã đóng vĩnh viễn</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_SystemStatus">System Status:&nbsp</label>
                        @if($restaurant->Restaurant_SystemStatus == 1) <span style="color:	#0000cd"><i class="fas fa-lock-open"></i> Mở khóa</span> @endif
                        @if($restaurant->Restaurant_SystemStatus == 0) <span style="color:	#cd0000"><i class="fas fa-lock"></i> Đang khóa</span> @endif
                    <select class="custom-select" name="Restaurant_SystemStatus" id="Restaurant_SystemStatus">
                        <option value="1" @if( $restaurant->Restaurant_SystemStatus == "1") selected @endif>Mở khóa</option>
                        <option value="0" @if( $restaurant->Restaurant_SystemStatus == "0") selected @endif>Đang khóa</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Restaurant_Description">Description:</label>
            <textarea name="Restaurant_Description" class="form-control" rows="5" id="Restaurant_Description">{{ $restaurant->Restaurant_Description }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ url("/backend/restaurant/info/$restaurant->id") }}" class="btn btn-info">Info</a>
        <a href="{{ url("/backend/restaurant/index") }}" class="btn btn-secondary">Trở về</a>
    </form>
@endsection
