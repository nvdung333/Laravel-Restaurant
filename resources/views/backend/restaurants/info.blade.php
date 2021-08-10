@extends('backend.layouts.main')
@section('title', 'Restaurants')

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
        <a href="{{ url("/backend/restaurant/index") }}" class="btn btn-secondary">Trở về</a>
        <a href="{{ url("/backend/restaurant/info/$restaurant->id") }}" class="btn btn-success">Refresh</a>
    </div>

    <form enctype="multipart/form-data">
        <div class="form-group">
            <span style="background: black; padding: 3px">
                <label style="color:white">ID:</label>
                <a style="color:lightgreen">{{ $restaurant->id }}</a>
            </span>
        </div>

        <div class="form-group">
            <label for="Restaurant_Name">Name:</label>
            <input type="text" name="Restaurant_Name" id="Restaurant_Name" class="form-control" value="{{ $restaurant->Restaurant_Name }}" readonly>
        </div>
        
        <div class="form-group">
            <label for="Restaurant_Address">Address:</label>
            <input type="text" name="Restaurant_Address" id="Restaurant_Address" class="form-control" value="{{ $restaurant->Restaurant_Address }}" readonly>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Area">Area:</label>
                    <input type="text" name="Restaurant_Area" id="Restaurant_Area" class="form-control" value="{{ $restaurant->Restaurant_Area }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_Phone">Phone Number:</label>
                    <input type="text" name="Restaurant_Phone" id="Restaurant_Phone" class="form-control" value="{{ $restaurant->Restaurant_Phone }}" readonly>
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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Restaurant_SystemStatus">System Status:&nbsp</label>
                    @if($restaurant->Restaurant_SystemStatus == 1) <span style="color:	#0000cd"><i class="fas fa-lock-open"></i> Mở khóa</span> @endif
                    @if($restaurant->Restaurant_SystemStatus == 0) <span style="color:	#cd0000"><i class="fas fa-lock"></i> Đang khóa</span> @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Restaurant_Description">Description:</label>
            <textarea name="Restaurant_Description" class="form-control" rows="5" id="Restaurant_Description" readonly>{{ $restaurant->Restaurant_Description }}</textarea>
        </div>

        <label>Created at:&nbsp</label><span>{{$restaurant->created_at}}</span><br>
        <label>Updated at:&nbsp</label><span>{{$restaurant->updated_at}}</span><br>
        <label>Created user:&nbsp</label>@foreach($users as $user) @if($user->id == $restaurant->created_user) <span>{{$user->User_FullName}}</span> @endif @endforeach <br>
        <label>Modified user:&nbsp</label>@foreach($users as $user) @if($user->id == $restaurant->modified_user) <span>{{$user->User_FullName}}</span> @endif @endforeach <br>

        <a href="{{ url("/backend/restaurant/edit/$restaurant->id") }}" class="btn btn-warning">Edit</a>
        <a href="{{ url("/backend/restaurant/delete/$restaurant->id") }}" class="btn btn-danger">Delete</a>
    </form>
@endsection
