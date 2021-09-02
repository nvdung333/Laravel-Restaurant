@extends('frontend.layouts.main')
@section('title', "Cart")

@section('content')

    <div class="container-md" id="cart-site-container">

        <p id="cart-site-title">Shopping Cart</p>

        <div class="table-responsive">
            <table id="cart-site-table" class="table table-bordered">
                <thead id="cart-site-thead">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-site-tbody">
                    @if (isset($items))
                        @foreach ($items as $item)
                            <tr>
                                <td rowspan="2">
                                    <p id="cart-site-tbody-name">{{$item['itemName']}}</p>
                                    <div id="cart-site-tbody-img">
                                        <?php $itemImage = str_replace("public/", "", $item['itemImage']); ?>
                                        <img class="card-img-top" src="{{ asset("/storage/$itemImage") }}" alt="item_img">
                                    </div>
                                </td>
                                <td id="cart-site-tbody-price">{{$item['itemPrice']}} <span>đ</span></td>
                                <td id="cart-site-tbody-quantity">
                                    <select class="custom-select custom-select-sm" id="QttSelOpt" data-sessionID="{{$item['sessionID']}}">
                                        @for ($i = 1; $i <= 100; $i++)
                                        <option value="{{$i}}" {{$i==$item['itemQuantity'] ? "selected" : ""}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td id="cart-site-tbody-total">{{(float)$item['itemPrice'] * (int)$item['itemQuantity']}} <span>đ</span></td>
                                <!-- REMOVE ITEM FROM CART -->
                                <td><button class="btn btn-warning btn-sm RemoveItem" data-sessionID="{{$item['sessionID']}}">X</button></td>
                                <!-- end -->
                            </tr>
                            <tr>
                                <td colspan="4" style="font-size: 90%;"><span style="font-weight:bold;">Note: </span>{{$item['itemNote']}}</td> 
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div id="cart-site-cont-shp">
            <a class="btn" href="{{ url('search') }}">CONTINUE SHOPPING</a>
            <!-- CLEAR CART -->
            <a class="btn btn-danger" style="color: white;" href="{{ url('/cart/clear/') }}">CLEAR ALL</a>
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
                            <p id="cart-site-box-right">{{$totalPrice}} <span>đ</span></p>
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