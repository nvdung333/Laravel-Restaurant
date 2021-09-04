@extends('frontend.layouts.main')
@section('title', "Cart")

@section('content')
    <div class="container-md" id="cart-site-container">

        <div id="cart-site-title">
            <p id="cart-site-title-main">Shopping Cart</p>
            <p id="cart-site-title-sub">(Lưu ý: Đăng nhập để theo dõi đơn đặt hàng)</p>
        </div>

        <div class="table-responsive">
            <table id="cart-site-table" class="table table-bordered">
                <tbody id="cart-site-tbody">
                    @if (isset($items))
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <?php $itemImage = str_replace("public/", "", $item['itemImage']); ?>
                                    <img id="cart-site-tbody-img" src="{{asset("/storage/$itemImage")}}" alt="">
                                </td>
                                <td>
                                    <p id="cart-site-tbody-name">{{$item['itemName']}}</p>
                                    <p id="cart-site-tbody-price"><span>{{$item['itemPrice']}}&nbspVNĐ</span></p>
                                    <p id="cart-site-tbody-qtt-label">Quantity:</p>
                                    <select class="custom-select custom-select-sm"
                                        style="background-color: #fff8dc; font-weight: bold; width:max-content"
                                        id="QttSelOpt" data-sessionID="{{$item['sessionID']}}">
                                        @for ($i = 1; $i <= 100; $i++)
                                        <option value="{{$i}}" {{$i==$item['itemQuantity'] ? "selected" : ""}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <p id="cart-site-tbody-total">Total: <span>{{(float)$item['itemPrice'] * (int)$item['itemQuantity']}}&nbspVNĐ</span></p>
                                    <p id="cart-site-tbody-note">Note: <span>{{$item['itemNote']}}</span></p>
                                </td>
                                <!-- REMOVE ITEM FROM CART -->
                                <td style="text-align: center; vertical-align: middle;">
                                    <button
                                        class="btn btn-warning RemoveItem"
                                        data-sessionID="{{$item['sessionID']}}">
                                        X
                                    </button>
                                </td>
                                <!-- end -->
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div id="cart-site-opt">
            <a id="cart-site-opt-continue" class="btn" href="{{ url('search') }}">CONTINUE SHOPPING</a>
            <!-- CLEAR CART -->
            <a class="btn btn-danger" href="{{ url('/cart/clear/') }}">CLEAR ALL</a>
            <!-- end -->
        </div>

        <div class="container">
            <div class="row">
                <div id="cart-site-box" class="col-md-6">
                    <h3 id="cart-site-box-title">Cart total</h3>
                    <div id="cart-site-box-row" class="row">
                        <div class="col-6">
                            <p id="cart-site-box-left">Total item(s)</p>
                        </div>
                        <div class="col-6">
                            <p id="cart-site-box-right">{{$totalItem}}</p>
                        </div>
                    </div>
                    <div id="cart-site-box-row" class="row">
                        <div class="col-6">
                            <p id="cart-site-box-left">Total quantity</p>
                        </div>
                        <div class="col-6">
                            <p id="cart-site-box-right">{{$totalQuantity}}</p>
                        </div>
                    </div>
                    <div id="cart-site-box-row" class="row">
                        <div class="col-6">
                            <p id="cart-site-box-left">Total price</p>
                        </div>
                        <div class="col-6">
                            <p id="cart-site-box-right">{{$totalPrice}}<span>&nbsp<u>đ</u></span></p>
                        </div>
                    </div>
                    <div id="cart-site-box-proceed">
                        <a class="btn" href="{{ url('payment') }}">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('appendjs')
    <script>
        $(document).ready(function () {

            // UPDATE ITEM QUANTITY
            $("body").on("change", "#QttSelOpt", function(e) {
                var ssID = $(this).attr("data-sessionID");
                var newQtt = $(this).val();
                var token = "{{ csrf_token() }}";
                var type = "PUT";
                var formData = {
                    ssID: ssID,
                    newQtt: newQtt,
                    _token: token,
                }
                var ajaxurl = "{{ url('/cart/update/') }}"+"/"+ssID;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    }
                });
            });
            
            // REMOVE ITEM
            $("body").on("click", ".RemoveItem", function(e) {
                var ssID = $(this).attr("data-sessionID");
                var token = "{{ csrf_token() }}";
                var type = "PUT";
                var formData = {
                    ssID: ssID,
                    _token: token,
                }
                var ajaxurl = "{{ url('/cart/remove/') }}"+"/"+ssID;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    }
                });
            });

        });
    </script>
@endsection