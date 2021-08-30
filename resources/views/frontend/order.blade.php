@extends('frontend.layouts.main')
@section('title', "$title")

@section('content')
    <div class="container-md" id="product-container">
        <div class="row no-gutters">
            
            @foreach ($products as $product)
            <div class="col-md-3 col-sm-4 col-6">
                <div class="card" id="product">
                    <div id="product-img">
                        <?php $product->Product_Img = str_replace("public/", "", $product->Product_Img); ?>
                        <img class="card-img-top" src="{{ asset("/storage/$product->Product_Img") }}" alt="product_img">
                    </div>
                    <div class="card-body" id="product-body">
                        <p id="product-name">{{ $product->Product_Name }}</p>
                        <span id="product-price">{{ $product->Product_Price }} <u>đ</u></span>
                        <div style="font-size: small">
                            @if($product->Product_AvailableStatus == 0)
                            <span style="color:white; background: #00c5cd">&nbspChưa mở bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 1)
                                <span style="color:white; background: #ffc125">&nbspSắp mở bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 2)
                                <span style="color:white; background: #008b00">&nbspĐang bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 3)
                                <span style="color:white; background: #8b2323">&nbspTạm ngưng bán&nbsp</span>
                            @endif
                            @if($product->Product_AvailableStatus == 4)
                                <span style="color:white; background: #999999">&nbspĐã ngưng bán&nbsp</span>
                            @endif
                        </div>
                        <p id="product-description">{{ $product->Product_Description }}</p>
                        <a id="product-add-btn" href="#" class="btn btn-success {{ $product->Product_AvailableStatus!=2 ? 'disabled' : '' }}">Mua ngay</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
@endsection

@section('cart-btn')
    @include('frontend.partials.cart-btn')
@endsection
