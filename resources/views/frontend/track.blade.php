@extends('frontend.layouts.main')
@section('title', "Track")

@section('content')
    <div class="container" id="track-container">

        <form id="track-form" method="post" action="{{ url('track') }}">
            @csrf
            <div class="row">
                <div class="col-sm-11">
                    <div class="form-group">
                        <label for="keyword">Tracking code:</label>
                        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Type here..." value="{{ $track_keyword }}">
                    </div>
                </div>
                <div class="col-sm-1">
                    <div class="form-group">
                        <label for="">Track</label>
                        <div><button class="btn" style="background-color: #5a5c69; color: white;"><i class="fas fa-search"></i></button></div>
                    </div>
                </div>
            </div>
        </form>

        @if (isset($order) && $order!=null)
            <table id="track-table-info" class="table table-bordered">
                <tr>
                    <th>Tracking Code</th>
                    <th>{{ $order->Order_TrackingCode }}</th>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        {{ $order->Order_Status == 0 ? $orderstatus[0] : "" }}
                        {{ $order->Order_Status == 1 ? $orderstatus[1] : "" }}
                        {{ $order->Order_Status == 2 ? $orderstatus[2] : "" }}
                        {{ $order->Order_Status == 3 ? $orderstatus[3] : "" }}
                        {{ $order->Order_Status == 4 ? $orderstatus[4] : "" }}
                        {{ $order->Order_Status == 5 ? $orderstatus[5] : "" }}
                    </td>
                </tr>
                <tr>
                    <th>Restaurant</th>
                    <td>{{ $order->Order_RestaurantName }}</td>
                </tr>
                <tr>
                    <th>Total Item</th>
                    <td>{{ $order->Order_TotalItem }}</td>
                </tr>
                <tr>
                    <th>Total Quantity</th>
                    <td>{{ $order->Order_TotalQuantity }}</td>
                </tr>
                <tr>
                    <th>Total Price</th>
                    <td>{{ $order->Order_TotalPrice }}</td>
                </tr>
                <tr>
                    <th>Order Note</th>
                    <td>{{ $order->Order_Note }}</td>
                </tr>
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
                    <th>Cancel By</th>
                    <td>{{ $order->Order_CancelBy }}</td>
                </tr>
                <tr>
                    <th>Cancel Reason</th>
                    <td>{{ $order->Order_CancelReason }}</td>
                </tr>
                <tr>
                    <th>Time Return</th>
                    <td>{{ $order->Order_Time_Return }}</td>
                </tr>
                <tr>
                    <th>Return Reason</th>
                    <td>{{ $order->Order_ReturnReason }}</td>
                </tr>
            </table>
        @endif

        @if (isset($orderdetails) && $orderdetails!=null)
            <h3 style="border-bottom: 1px solid darkgreen; padding-bottom: 12px; color: darkgreen;">Order details</h3>
            <table class="table table-bordered table-sm">
                <tbody style="color: darkolivegreen">
                    @foreach ($orderdetails as $orderdetail)
                    <tr>
                        <td>
                            <label style="font-size: large">
                                <i class="far fa-sticky-note"></i>
                                <b>{{ $orderdetail->OrderDetail_ProductName }} (x{{$orderdetail->OrderDetail_Quantity}})</b>
                            </label><br>
                            <label>- Price: <b>{{ $orderdetail->OrderDetail_ProductPrice }}</b></label><br>
                            <label>- Total Price: <b>{{ $orderdetail->OrderDetail_TotalPrice }}</b></label><br>
                            <label>- Detail Note: <b>{{ $orderdetail->OrderDetail_Note }}</b></label>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection