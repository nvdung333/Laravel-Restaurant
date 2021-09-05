@extends('frontend.layouts.main')
@section('title', "Completed")

@section('content')
    
    @if (isset($checkcomplete))
        <div class="container" id="completed-container">
            <div id="completed-message">
                <p id="completed-message-main">ĐẶT HÀNG THÀNH CÔNG!</p>
                <p id="completed-message-body">
                    Chúng tôi sẽ liên hệ với bạn sớm nhất.
                    Để có thể theo dõi đơn đặt hàng, vui lòng lưu lại mã theo dõi dưới đây:
                </p>
                <span id="completed-message-code">{{$code}}</span>
            </div>
        </div>
    @else
        <div class="container" style="padding: 30px">
            <b>NO DATA FOUND!</b>
        </div>
    @endif

@endsection
