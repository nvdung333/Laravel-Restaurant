@extends('backend.layouts.main')
@section('title', 'Orders')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thông tin chi tiết đơn đặt hàng</h1>
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
        <a href="{{ url("/backend/order/index") }}" class="btn btn-secondary">Trở về</a>
        <a href="{{ url("/backend/order/info/$order->id") }}" class="btn btn-success">Refresh</a>
    </div>

    <form method="post" action="{{ url("/backend/order/info/$order->id") }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <span style="background: black; padding: 3px">
                <label style="color:white">ID:</label>
                <a style="color:lightgreen">{{ $order->id }}</a>
            </span>
        </div>

        <div style="border: 1px solid grey; border-radius: 5px; padding: 11px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Tracking Code:</label>
                        <span type="text" style="font-weight: bold;">{{ $order->Order_TrackingCode }}</span>
                        <br>
                        <label>Status:</label>
                        @if ($order->Order_Status == 0) <span style="background: white; color: black; padding: 0 5px;"><i class="fas fa-window-close"></i> {{$status[0]}}</span> @endif
                        @if ($order->Order_Status == 1) <span style="background: #00cd66; color: white; padding: 0 5px;">{{$status[1]}}</span> @endif
                        @if ($order->Order_Status == 2) <span style="background: #4876ff; color: white; padding: 0 5px;">{{$status[2]}}</span> @endif
                        @if ($order->Order_Status == 3) <span style="background: #ffc125; color: white; padding: 0 5px;">{{$status[3]}}</span> @endif
                        @if ($order->Order_Status == 4) <span style="background: #cd5b45; color: white; padding: 0 5px;">{{$status[4]}}</span> @endif
                        @if ($order->Order_Status == 5) <span style="background: black; color: white; padding: 0 5px;">{{$status[5]}}</span> @endif
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Name:</label>
                        <input type="text" class="form-control" value="{{ $order->Customer_Name }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Phone:</label>
                        <input type="text" class="form-control" value="{{ $order->Customer_Phone }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Customer Email:</label>
                        <input type="text" class="form-control" value="{{ $order->Customer_Email }}" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Customer Address:</label>
                        <input type="text" name="Customer_Address" class="form-control" value="{{ $order->Customer_Address }}" >
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Restaurant:</label>
                        <input type="text" class="form-control" value="{{ $order->Order_RestaurantName }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Restaurant: (for editing)</label>
                        <select class="custom-select" name="Restaurant_ID">
                            <option value="">Choose...</option>
                            @foreach ($restaurants as $restaurant)
                                <option value="{{$restaurant->id}}"
                                    @if($order->Restaurant_ID == $restaurant->id) selected @endif>
                                    {{$restaurant->Restaurant_Name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Restaurant Staff:</label>
                        <input type="text" name="Restaurant_Staff" class="form-control" value="{{ $order->Restaurant_Staff }}">
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Order_Note">Note:</label>
                        <textarea class="form-control" rows="3" readonly>{{$order->Order_Note}}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-dark">Update</button>
        </div>
    </form>

    <div class="div" style="border: 1px solid grey; border-radius: 5px; padding: 11px; margin-bottom: 12px;">
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive-md">
                    <table class="table table-bordered">
                        <tr>
                            <th>Time Request</th>
                            <td>{{ $order->Order_Time_Request }}</td>
                        </tr>
                        <tr>
                            <th>Time Accept</th>
                            <td>{{ $order->Order_Time_Accept }}</td>
                        </tr>
                        <tr>
                            <th>Time Complete</th>
                            <td>{{ $order->Order_Time_Complete }}</td>
                        </tr>
                        <tr>
                            <th>Time Receive</th>
                            <td>{{ $order->Order_Time_Receive }}</td>
                        </tr>
                        <tr>
                            <th>Time Cancel</th>
                            <td>{{ $order->Order_Time_Cancel }}</td>
                        </tr>
                        <tr>
                            <th>Time Return</th>
                            <td>{{ $order->Order_Time_Return }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-responsive-md">
                    <table class="table table-bordered">
                        <tr>
                            <th>Created At</th>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $order->updated_at }}</td>
                        </tr>
                        <tr>
                            <th>Created User</th>
                            <td> @foreach ($users as $user) @if ($user->id == $order->created_user) {{ $user->User_FullName }} @endif @endforeach </td>
                        </tr>
                        <tr>
                            <th>Modified User</th>
                            <td> @foreach ($users as $user) @if ($user->id == $order->modified_user) {{ $user->User_FullName }} @endif @endforeach </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive-md">
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <th colspan="2">Order Details</th>
            </thead>
            @foreach ($orderdetails as $orderdetail)
                <tr>
                    <td>
                        <label style="font-size: large">
                            <i class="far fa-sticky-note"></i>
                            Product: <b>{{$orderdetail->OrderDetail_ProductName}} (x{{$orderdetail->OrderDetail_Quantity}})</b>
                        </label><br>
                        <label>- Price: <b>{{$orderdetail->OrderDetail_ProductPrice}}</b></label><br>
                        <label>- Total Price: <b>{{$orderdetail->OrderDetail_TotalPrice}}</b></label><br>
                        <label>- Detail Note: <b>{{$orderdetail->OrderDetail_Note}}</b></label><br>
                    </td>
                    <td>
                        <label>- Order detail id: <b>{{$orderdetail->id}}</b></label><br>
                        <label>- Created at: <b>{{$orderdetail->created_at}}</b></label><br>
                        <label>- Updated at: <b>{{$orderdetail->updated_at}}</b></label><br>
                        <label>- Created user id: <b>{{$orderdetail->created_user}}</b></label><br>
                        <label>- Modified user id: <b>{{$orderdetail->modified_user}}</b></label>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="row" style="text-align: center">
        <div class="col-md-3">
            <form method="post" action="{{ url("/backend/order/status/$order->id") }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="orderRequest" value="1">
                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-success">SET REQUEST</button>
            </form>
        </div>
        <div class="col-md-3">
            <form method="post" action="{{ url("/backend/order/status/$order->id") }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="orderAccept" value="1">
                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-primary">SET ACCEPT</button>
            </form>
        </div>
        <div class="col-md-3">
            <form method="post" action="{{ url("/backend/order/status/$order->id") }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="orderComplete" value="1">
                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-warning">SET COMPLETE</button>
            </form>
        </div>
        <div class="col-md-3">
            <form method="post" action="{{ url("/backend/order/status/$order->id") }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="orderReceive" value="1">
                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-danger">SET RECEIVE</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{ url("/backend/order/status/$order->id") }}" enctype="multipart/form-data" style="border: 1px solid grey; border-radius: 5px; padding: 11px;">
                @csrf
                <div class="form-group">
                    <label>Cancel by: {{$order->Order_CancelBy}}</label><br>
                    <label>Cancel reason:</label>
                    <input type="hidden" name="orderCancel" value="1">
                    <input type="text" name="Order_CancelReason" class="form-control" value="{{ $order->Order_CancelReason }}">
                </div>
                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-dark">CANCEL ORDER</button>
            </form>
        </div>
        <div class="col-md-12">
            <form method="post" action="{{ url("/backend/order/status/$order->id") }}" enctype="multipart/form-data" style="border: 1px solid grey; border-radius: 5px; padding: 11px;">
                @csrf
                <div class="form-group">
                    <label>Return reason:</label>
                    <input type="hidden" name="orderReturn" value="1">
                    <input type="text" name="Order_ReturnReason" class="form-control" value="{{ $order->Order_ReturnReason }}">
                </div>
                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-dark">RETURN GOODS</button>
            </form>
        </div>
    </div>


@endsection