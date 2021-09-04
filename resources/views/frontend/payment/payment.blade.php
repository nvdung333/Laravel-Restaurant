@extends('frontend.layouts.main')
@section('title', "Payment")

@section('content')
    <div class="container-md" id="payment-container">

        <div id="payment-title">
            <p id="payment-title-main">Payment Information</p>
            <p id="payment-title-sub">(Lưu ý: Đăng nhập để theo dõi đơn đặt hàng)</p>
        </div>

        <form id="payment-form" method="POST" action="#">
            <div class="row no-gutters">

                <div class="col-md-7 col-sm-5" style="padding: 1px;">
                    <div id="payment-form-left">
                        <div class="form-group">
                            <label>Choose a store near you:</label>
                                <select class="custom-select" id="" required>
                                <option selected disabled value="">Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Your name:</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Type here..." required>
                        </div>
                        <div class="form-group">
                            <label>Your phone number:</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Type here..." required>
                        </div>
                        <div class="form-group">
                            <label>Your address:</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Type here..." required>
                        </div>
                        <div class="form-group">
                            <label>Your email:</label>
                            <input type="email" name="" id="" class="form-control" placeholder="Type here...">
                        </div>
                        <div class="form-group">
                            <label>Note:</label>
                            <input type="text" name="" id="" class="form-control" placeholder="Type here...">
                        </div>
                        <div>
                            <a id="payment-form-opt-return" class="btn" href="{{url('cart')}}">RETURN CART</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-7" style="padding: 1px;">
                    <div id="payment-form-right">
                        <p id="payment-form-right-title">ĐƠN HÀNG</p>
                        <table id="payment-form-right-table" class="table table-borderless">
                            <tr>
                                <td style="text-align: left;">Phở Xào&nbsp(x2)</td>
                                <td style="text-align: right;">90000&nbsp<u>đ</u></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">Hủ Tiếu&nbsp(x3)</td>
                                <td style="text-align: right;">120000&nbsp<u>đ</u></td>
                            </tr>
                            <tr id="payment-form-right-table-total">
                                <th style="text-align: left; color: darkgreen;">THÀNH TIỀN</th>
                                <th style="text-align: right; color: darkgreen;">210000&nbsp<u>đ</u></th>
                            </tr>
                        </table>
                        <div id="payment-form-right-submit">
                            <button type="submit" class="btn">ORDER</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection
