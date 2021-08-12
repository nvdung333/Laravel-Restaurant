@extends('backend.layouts.main')
@section('title', 'User Setting')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List of users</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div style="padding-bottom: 10px">
        <a href="{{ url("/backend") }}" class="btn btn-primary">Home</a>
        <a href="{{ url("/backend/user/admin") }}" class="btn btn-danger">Admin Setting</a>
        <a href="{{ url("/backend/user/role") }}" class="btn btn-warning">Role Setting</a>
        <a href="{{ url("/backend/user/index") }}" class="btn btn-success">Refresh</a>
    </div>

    <form name="searchfilter" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" style="border: 1px solid grey; border-radius: 5px; padding: 10px;">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label for="keyword">Tìm kiếm</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search for..." value="{{ $search_keyword }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="is_admin">Filter by...</label>
                    <select name="is_admin" id="is_admin" class="custom-select">
                        <option value="">All users</option>
                        <option value="1" {{ $is_admin == '1' ? "selected" : "" }}>System admin</option>
                        <option value="0" {{ $is_admin == '0' ? "selected" : "" }}>Not system admin</option>
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
                <th>Username</th>
                <th>User_FullName</th>
                <th>User_Email</th>
                <th>User_Phone</th>
                <th>User_Address</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($users) && !empty($users))
                @foreach($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <td>
                        @if($user->is_admin == 1)
                            <span style="color:	#ccac00"><i class="fas fa-user-shield"></i></span>
                        @endif
                    </td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->User_FullName }}</td>
                    <td>{{ $user->User_Email }}</td>
                    <td>{{ $user->User_Phone }}</td>
                    <td>{{ $user->User_Address }}</td>
                </tr>
                @endforeach
            @else
                Chưa có bản ghi nào trong bảng này
            @endif
        </tbody>
    </table>

    {{ $users->links("pagination::bootstrap-4") }}

@endsection