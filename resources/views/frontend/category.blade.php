@extends('frontend.layouts.main')
@section('title', "$title")

@section('content')

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
                    <p id="product-description">{{ $product->Product_Description }}</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
@endsection

@section('cart-btn')
    @include('frontend.partials.cart-btn')
@endsection
