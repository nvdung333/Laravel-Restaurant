@extends('frontend.layouts.main')
@section('title', "History")

@section('content')
    <div class="container-md" id="track-container">
        @if (isset($orders) and $orders->toarray() != null)
            <div class="table-responsive-md">
                <table class="table table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr style="font-size:large; text-align:center">
                            <th>Order History</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <label style="font-weight:bold;"><i class="far fa-folder"></i> {{ $order->Order_TrackingCode }}</label><br>
                                <label style="font-size:small">
                                    @if ($order->Order_Status == 0) <span style="background:#f5f5f5; color:black; padding:2px 5px;"><i class="fas fa-window-close"></i> {{$status[0]}}</span> @endif
                                    @if ($order->Order_Status == 1) <span style="background:#008b00; color:white; padding:2px 5px;">{{$status[1]}}</span> @endif
                                    @if ($order->Order_Status == 2) <span style="background:#00008b; color:white; padding:2px 5px;">{{$status[2]}}</span> @endif
                                    @if ($order->Order_Status == 3) <span style="background:#8b8b00; color:white; padding:2px 5px;">{{$status[3]}}</span> @endif
                                    @if ($order->Order_Status == 4) <span style="background:#8b0000; color:white; padding:2px 5px;">{{$status[4]}}</span> @endif
                                    @if ($order->Order_Status == 5) <span style="background:black; color:white; padding:2px 5px;">{{$status[5]}}</span> @endif
                                </label><br>
                                <label>- Total Quantity: {{ $order->Order_TotalQuantity }}</label><br>
                                <label>- Total Price: {{ $order->Order_TotalPrice }}</label><br>
                                <label>- Time Request: {{ $order->Order_Time_Request }}</label><br>
                                <label>- Time Receive: {{ $order->Order_Time_Receive }}</label>
                            </td>
                            <td style="vertical-align:middle; text-align:center"><a href="{{ url("/user/history/$order->id") }}" class="btn btn-success" data-toggle="tooltip" title="Info"><i class="fas fa-info-circle"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links("pagination::bootstrap-4") }}
        @else
            <br>
            <p> <b>NO DATA FOUND!</b> </p>
        @endif
    </div>
@endsection