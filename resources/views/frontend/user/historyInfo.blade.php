@extends('frontend.layouts.main')
@section('title', "History")

@section('content')

    <style>
        #track-container input:read-only, #track-container textarea:read-only
        {background-color:lemonchiffon; color:saddlebrown}
    </style>

    <div class="container-md" id="track-container">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- order info --}}
            @if (isset($order) && !empty($order))
                <div style="padding-bottom: 10px">
                    <a href="{{ url("/user/history/") }}" class="btn btn-secondary">Trở về</a>
                    <a href="{{ url("/user/history/$order->id") }}" class="btn btn-success">Refresh</a>
                </div>

                <div style="border: 1px solid saddlebrown; border-radius: 5px; padding: 11px; margin-bottom: 12px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tracking Code:</label>
                                <span type="text" style="font-weight: bold;">{{ $order->Order_TrackingCode }}</span>
                                <br>
                                <label>Status:</label>
                                @if ($order->Order_Status == 0) <span style="background:#f5f5f5; color:black; padding:2px 5px;"><i class="fas fa-window-close"></i> {{$status[0]}}</span> @endif
                                @if ($order->Order_Status == 1) <span style="background:#008b00; color:white; padding:2px 5px;">{{$status[1]}}</span> @endif
                                @if ($order->Order_Status == 2) <span style="background:#00008b; color:white; padding:2px 5px;">{{$status[2]}}</span> @endif
                                @if ($order->Order_Status == 3) <span style="background:#8b8b00; color:white; padding:2px 5px;">{{$status[3]}}</span> @endif
                                @if ($order->Order_Status == 4) <span style="background:#8b0000; color:white; padding:2px 5px;">{{$status[4]}}</span> @endif
                                @if ($order->Order_Status == 5) <span style="background:black; color:white; padding:2px 5px;">{{$status[5]}}</span> @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Customer Name:</label>
                                <input id="abc" type="text" class="form-control" value="{{ $order->Customer_Name }}" readonly>
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
                                <input type="text" class="form-control" value="{{ $order->Customer_Address }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restaurant:</label>
                                <input type="text" class="form-control" value="{{ $order->Order_RestaurantName }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restaurant Staff:</label>
                                <input type="text" class="form-control" value="{{ $order->Restaurant_Staff }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="div" style="border: 1px solid saddlebrown; border-radius: 5px; padding: 11px; margin-bottom: 12px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive-md">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Time Request</td>
                                        <th>{{ $order->Order_Time_Request }}</th>
                                    </tr>
                                    <tr>
                                        <td>Time Accept</td>
                                        <th>{{ $order->Order_Time_Accept }}</th>
                                    </tr>
                                    <tr>
                                        <td>Time Complete</td>
                                        <th>{{ $order->Order_Time_Complete }}</th>
                                    </tr>
                                    <tr>
                                        <td>Time Receive</td>
                                        <th>{{ $order->Order_Time_Receive }}</th>
                                    </tr>
                                    <tr>
                                        <td>Time Cancel</td>
                                        <th>{{ $order->Order_Time_Cancel }}</th>
                                    </tr>
                                    <tr>
                                        <td>Cancel By</td>
                                        <th>{{ $order->Order_CancelBy }}</th>
                                    </tr>
                                    <tr>
                                        <td>Cancel Reason</td>
                                        <th>{{ $order->Order_CancelReason }}</th>
                                    </tr>
                                    <tr>
                                        <td>Time Return</td>
                                        <th>{{ $order->Order_Time_Return }}</th>
                                    </tr>
                                    <tr>
                                        <td>Return Reason</td>
                                        <th>{{ $order->Order_ReturnReason }}</th>
                                    </tr>
                                    <tr>
                                        <td>Created At</td>
                                        <th>{{ $order->created_at }}</th>
                                    </tr>
                                    <tr>
                                        <td>Updated At</td>
                                        <th>{{ $order->updated_at }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <br>
                <p> <b>NO DATA FOUND!</b> </p>
            @endif
        {{-- end order info --}}

        {{-- details info --}}
            @if (isset($orderdetails) && !empty($orderdetails->toarray()))
                <div class="table-responsive-md">
                    <table class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <th colspan="1" style="font-size:large;">Order Details</th>
                        </thead>
                        @foreach ($orderdetails as $orderdetail)
                            <tr>
                                <td>
                                    <label style="font-size:large;">
                                        <i class="far fa-sticky-note"></i>
                                        Product: <b>{{$orderdetail->OrderDetail_ProductName}} (x{{$orderdetail->OrderDetail_Quantity}})</b>
                                    </label><br>
                                    <label>- Price: <b>{{$orderdetail->OrderDetail_ProductPrice}}</b></label><br>
                                    <label>- Total Price: <b>{{$orderdetail->OrderDetail_TotalPrice}}</b></label><br>
                                    <label>- Detail Note: <b>{{$orderdetail->OrderDetail_Note}}</b></label><br>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="form-group">
                    <label for="Order_Note">Note:</label>
                    <textarea class="form-control" rows="3" readonly>{{$order->Order_Note}}</textarea>
                </div>
            @else
                <br>
                <p> <b>NO DATA FOUND!</b> </p>
            @endif
        {{-- end details info --}}

        {{-- section cancel & return --}}
            @if (isset($order) && !empty($order))
                <div class="row">
                    @if ($order->Order_Status == 1)
                        <div class="col-md-12">
                            <form method="post" action="{{ url("/user/history/$order->id") }}"
                                enctype="multipart/form-data"
                                style="border: 1px solid grey; border-radius: 5px; padding: 11px; margin-bottom: 12px">
                                @csrf
                                <div class="form-group">
                                    <label>Cancel reason:</label>
                                    <input type="hidden" name="Order_Status" value="0">
                                    <input type="text" name="Order_CancelReason" class="form-control" value="{{ $order->Order_CancelReason }}">
                                </div>
                                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-dark">SET CANCEL ORDER</button>
                            </form>
                        </div>
                    @endif
                    @if ($order->Order_Status == 4)
                        <div class="col-md-12">
                            <form method="post" action="{{ url("/user/history/$order->id") }}"
                                enctype="multipart/form-data"
                                style="border: 1px solid grey; border-radius: 5px; padding: 11px; margin-bottom: 12px">
                                @csrf
                                <div class="form-group">
                                    <label>Return reason:</label>
                                    <input type="hidden" name="Order_Status" value="5">
                                    <input type="text" name="Order_ReturnReason" class="form-control" value="{{ $order->Order_ReturnReason }}">
                                </div>
                                <button type="submit" onclick='return confirm("Are you sure?")' class="btn btn-dark">SET RETURN GOODS</button>
                            </form>
                        </div>
                    @endif
                </div>
            @else
                <br>
                <p> <b>NO DATA FOUND!</b> </p>
            @endif
        {{-- end section cancel & return --}}

    </div>
@endsection