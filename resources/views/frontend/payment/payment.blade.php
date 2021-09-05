@extends('frontend.layouts.main')
@section('title', "Payment")

@section('content')
    <div class="container-md" id="payment-container">

        <div id="payment-title">
            <p>Payment Information</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($items) && !empty($items))
            <form id="payment-form" method="POST" action="{{url('payment/checkout')}}">
                <div class="row no-gutters">
                    @csrf

                    <div class="col-md-7 col-sm-5" style="padding: 1px;">
                        <div id="payment-form-left">
                            <div class="form-group">
                                <label>Choose a store near you:</label>
                                    <select name="Restaurant_ID" id="" class="custom-select" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{$store->Restaurant_Name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="User_ID" id="" value="{{ isset($auth['User_ID']) ? $auth['User_ID'] : "" }}">
                            <div class="form-group">
                                <label>Your name:</label>
                                <input type="text" name="Customer_Name"
                                    id="" class="form-control" placeholder="Type here..." required
                                    value="{{ old('Customer_Name', isset($auth['Customer_Name']) ? $auth['Customer_Name'] : "") }}">
                            </div>
                            <div class="form-group">
                                <label>Your phone number:</label>
                                <input type="text" name="Customer_Phone"
                                    id="" class="form-control" placeholder="Type here..." required
                                    value="{{ old('Customer_Phone', isset($auth['Customer_Phone']) ? $auth['Customer_Phone'] : "") }}">
                            </div>
                            <div class="form-group">
                                <label>Your address:</label>
                                <input type="text" name="Customer_Address"
                                    id="" class="form-control" placeholder="Type here..." required
                                    value="{{ old('Customer_Address', isset($auth['Customer_Address']) ? $auth['Customer_Address'] : "") }}">
                            </div>
                            <div class="form-group">
                                <label>Your email:</label>
                                <input type="email" name="Customer_Email"
                                    id="" class="form-control" placeholder="Type here..."
                                    value="{{ old('Customer_Email', isset($auth['Customer_Email']) ? $auth['Customer_Email'] : "") }}">
                            </div>
                            <div class="form-group">
                                <label>Note:</label>
                                <input type="text" name="Order_Note"
                                    id="" class="form-control" placeholder="Type here..."
                                    value="{{ old('Order_Note', "") }}">
                            </div>
                            <div id="payment-form-opt-return">
                                <a class="btn" href="{{url('cart')}}">RETURN CART</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-7" style="padding: 1px;">
                        <div id="payment-form-right">
                            <p id="payment-form-right-title">ĐƠN HÀNG</p>
                            <table id="payment-form-right-table" class="table table-borderless">

                                @foreach ($items as $item)
                                    <tr>
                                        <td style="text-align: left;">{{ $item['itemName'] }}&nbsp(x{{ $item['itemQuantity'] }})</td>
                                        <td style="text-align: right;">{{ $item['itemPrice'] * $item['itemQuantity'] }}&nbsp<u>đ</u></td>
                                    </tr>
                                @endforeach
                                <tr id="payment-form-right-table-total">
                                    <th style="text-align: left; color: darkgreen;">THÀNH TIỀN</th>
                                    <th style="text-align: right; color: darkgreen;">{{ $totalPrice }}&nbsp<u>đ</u></th>
                                </tr>

                            </table>
                            <div id="payment-form-right-submit">
                                <button type="submit"
                                    class="btn" {{ ($items == null) ? 'disabled' : '' }}
                                    style="{{ ($items == null) ? 'display:none' : '' }}"
                                    onclick='return confirm("Are you sure?")'>
                                    ORDER
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        @else
            <br>
            <p> <b>NO DATA FOUND!</b> </p>
        @endif
    </div>
@endsection
