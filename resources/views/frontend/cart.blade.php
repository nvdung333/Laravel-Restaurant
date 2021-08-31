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
                    <tr>
                        <td>Phở Xào</td>
                        <td id="cart-site-tbody-price">45000 <span>đ</span></td>
                        <td id="cart-site-tbody-quantity">
                            <select class="custom-select custom-select-sm" id="option1">
                                @for ($i = 1; $i <= 100; $i++)
                                <option value="{{$i}}" {{$i==2 ? "selected" : ""}}>{{$i}}</option>
                                @endfor
                            </select>
                        </td>
                        <td id="cart-site-tbody-total">90000 <span>đ</span></td>
                        <td>x</td>
                    </tr>
                    <tr>
                        <td>Hủ Tiếu</td>
                        <td id="cart-site-tbody-price">40000 <span>đ</span></td>
                        <td id="cart-site-tbody-quantity">
                            <select class="custom-select custom-select-sm" id="option2">
                                @for ($i = 1; $i <= 100; $i++)
                                <option value="{{$i}}" {{$i==3 ? "selected" : ""}}>{{$i}}</option>
                                @endfor
                            </select>
                        </td>
                        <td id="cart-site-tbody-total">120000 <span>đ</span></td>
                        <td>x</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="cart-site-cont-shp">
            <a class="btn" href="{{ url('search') }}">CONTINUE SHOPPING</a>
        </div>

        <div class="container">
            <div class="row">
                <div id="cart-site-box" class="col-md-6">
                    <h3 id="cart-site-box-title">Cart total</h3>
                    <div id="cart-site-box-row" class="row">
                        <div class="col-6">
                            <p id="cart-site-box-left">Total quantity</p>
                        </div>
                        <div class="col-6">
                            <p id="cart-site-box-right">5</p>
                        </div>
                    </div>
                    <div id="cart-site-box-row" class="row">
                        <div class="col-6">
                            <p id="cart-site-box-left">Total price</p>
                        </div>
                        <div class="col-6">
                            <p id="cart-site-box-right">210000 <span>đ</span></p>
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