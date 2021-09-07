@extends('backend.layouts.main')
@section('title', 'Orders')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách đơn đặt hàng</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (isset($customErrors) && !empty($customErrors))
        <div class="alert alert-danger">
            <ul>
                @foreach ($customErrors as $customError)
                    <li>{{ $customError }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="padding-bottom: 10px">
        <a href="{{ url("/backend/order/index") }}" class="btn btn-success">Refresh</a>
    </div>

    <form name="searchfilter" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" style="border: 1px solid grey; border-radius: 5px; padding: 10px;">
        
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="keyword">Tìm kiếm (nhập theo Mã track / SĐT / Email)</label>
                    <input type="text" name="keyword" class="form-control" placeholder="Search for..." value="{{ $search_keyword }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Trạng thái...</label>
                    <select name="whereStatus" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="1" {{ $whereStatus == "1" ? "selected" : "" }}>{{$status[1]}}</option>
                        <option value="2" {{ $whereStatus == "2" ? "selected" : "" }}>{{$status[2]}}</option>
                        <option value="3" {{ $whereStatus == "3" ? "selected" : "" }}>{{$status[3]}}</option>
                        <option value="4" {{ $whereStatus == "4" ? "selected" : "" }}>{{$status[4]}}</option>
                        <option value="5" {{ $whereStatus == "5" ? "selected" : "" }}>{{$status[5]}}</option>
                        <option value="0" {{ $whereStatus == "0" ? "selected" : "" }}>{{$status[0]}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Sắp xếp theo...</label>
                    <select name="orderby" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="Order_Status" {{ $order_by == "Order_Status" ? "selected" : "" }}>Status</option>
                        <option value="Order_TotalPrice" {{ $order_by == "Order_TotalPrice" ? "selected" : "" }}>Total Price</option>
                        <option value="Order_RestaurantName" {{ $order_by == "Order_RestaurantName" ? "selected" : "" }}>Restaurant</option>
                        <option value="Order_Time_Request" {{ $order_by == "Order_Time_Request" ? "selected" : "" }}>Time Request</option>
                        <option value="Order_Time_Complete" {{ $order_by == "Order_Time_Complete" ? "selected" : "" }}>Time Complete</option>
                        <option value="Order_Time_Receive" {{ $order_by == "Order_Time_Receive" ? "selected" : "" }}>Time Receive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Hướng sắp xếp...</label>
                    <select name="orderdir" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="ASC" {{ $order_dir == "ASC" ? "selected" : "" }}>Ascending</option>
                        <option value="DESC" {{ $order_dir == "DESC" ? "selected" : "" }}>Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Lấy mốc thời gian...</label>
                    <select name="whereBetween" class="custom-select">
                        <option value="" disabled>Choose...</option>
                        <option value="Order_Time_Request" {{ $whereBetween == "Order_Time_Request" ? "selected" : "" }}>Time_Request</option>
                        <option value="Order_Time_Accept" {{ $whereBetween == "Order_Time_Accept" ? "selected" : "" }}>Time_Accept</option>
                        <option value="Order_Time_Complete" {{ $whereBetween == "Order_Time_Complete" ? "selected" : "" }}>Time_Complete</option>
                        <option value="Order_Time_Receive" {{ $whereBetween == "Order_Time_Receive" ? "selected" : "" }}>Time_Receive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Time start:</label>
                    <input type="text" class="form-control" name="time_start" data-field="datetime" value="{{$time_start}}" placeholder="Click to pick..." readonly>
                    <div id="dtBox"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Time end:</label>
                    <input type="text" class="form-control" name="time_end" data-field="datetime" value="{{$time_end}}" placeholder="Click to pick..." readonly>
                    <div id="dtBox"></div>
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

    <div class="table-responsive-md">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Tracking Code</th>
                    <th>Tt price</th>
                    <th>Restaurant</th>
                    <th>Time Request</th>
                    <th>Time Complete</th>
                    <th>Time Receive</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($orders) && !empty($orders))
                    @foreach($orders as $order)
                    <tr>
                        <td><span style="font-weight: bold">{{ $order->Order_TrackingCode }}</span><br>
                            @if ($order->Order_Status == 0) <span style="background: white; color: black; padding: 0 5px;"><i class="fas fa-window-close"></i> {{$status[0]}}</span> @endif
                            @if ($order->Order_Status == 1) <span style="background: #00cd66; color: white; padding: 0 5px;">{{$status[1]}}</span> @endif
                            @if ($order->Order_Status == 2) <span style="background: #4876ff; color: white; padding: 0 5px;">{{$status[2]}}</span> @endif
                            @if ($order->Order_Status == 3) <span style="background: #ffc125; color: white; padding: 0 5px;">{{$status[3]}}</span> @endif
                            @if ($order->Order_Status == 4) <span style="background: #cd5b45; color: white; padding: 0 5px;">{{$status[4]}}</span> @endif
                            @if ($order->Order_Status == 5) <span style="background: black; color: white; padding: 0 5px;">{{$status[5]}}</span> @endif
                        </td>
                        <td>{{ $order->Order_TotalPrice }}</td>
                        <td>{{ $order->Order_RestaurantName }}</td>
                        <td>{{ $order->Order_Time_Request }}</td>
                        <td>{{ $order->Order_Time_Complete }}</td>
                        <td>{{ $order->Order_Time_Receive }}</td>
                        <td><a href="{{ url("/backend/order/info/$order->id") }}" class="btn btn-secondary" data-toggle="tooltip" title="Info"><i class="fas fa-info-circle"></i></a></td>
                    </tr>
                    @endforeach
                @else
                    Chưa có bản ghi nào trong bảng này
                @endif
            </tbody>
        </table>
    </div>

    {{ $orders->links("pagination::bootstrap-4") }}

@endsection

@section('appendjs')
    <script>
        $(document).ready(function() {
            $("#dtBox").DateTimePicker();
        });
    </script>
@endsection