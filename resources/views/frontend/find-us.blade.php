@extends('frontend.layouts.main')
@section('title', 'Find Us')

@section('content')

    <div class="container-fluid">
        <div class="row no-gutters">

            @foreach ($areas as $area)
                <div class="col-md-4" style="padding: 1px 2px">
                    <div style="border: 1px solid black; padding: 5px">
                        <p style="background: #eeeed1; padding: 0px 7px; font-weight:bold; font-size: 30px; text-align: center">{{ $area }}</p>
                        @foreach ($restaurants as $restaurant)
                            @if ($area == $restaurant->Restaurant_Area)
                                <label style="font-weight: bold; font-size:large "><i class="fas fa-map-marker-alt"></i> {{ $restaurant->Restaurant_Name }}</label><br>
                                <label>- Address: {{ $restaurant->Restaurant_Address }}</label><br>
                                <label>- Phone Number: {{ $restaurant->Restaurant_Phone }}</label><br>
                                <label>- Status: 
                                    @if($restaurant->Restaurant_OpenStatus == 0) <span style="color: #00008b; ">Sắp khai trương</span> @endif
                                    @if($restaurant->Restaurant_OpenStatus == 1) <span style="color: #006400; ">Đang hoạt động</span> @endif
                                    @if($restaurant->Restaurant_OpenStatus == 2) <span style="color: #cd6600; ">Tạm ngưng hoạt động</span> @endif
                                    @if($restaurant->Restaurant_OpenStatus == 3) <span style="color: #cd0000; ">Đã đóng vĩnh viễn</span> @endif
                                </label><br>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection

@section('cart-btn')
    @include('frontend.partials.cart-btn')
@endsection