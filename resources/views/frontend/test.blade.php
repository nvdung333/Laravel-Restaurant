@extends('frontend.layouts.main')
@section('title', 'Test')

@section('content')
    <div class="row no-gutters">

        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/0.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món ngắn gọn 1 dòng</p>
                    <span id="product-price">30000 <u>đ</u></span>
                    <p id="product-description">Mô tả Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/1.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món dài dằng dặc siêu dài, dài lê thê </p>
                    <span id="product-price">30000 <u>đ</u></span>
                    <p id="product-description">Mô tả 12323. Mô tả 123. Mô tả 123. Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/1.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món ngắn gọn 1 dòng</p>
                    <span id="product-price">300000 <u>đ</u></span>
                    <p id="product-description">Mô tả 12323. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.ô tả 123. Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/0.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món ngắn gọn 1 dòng</p>
                    <span id="product-price">3000 <u>đ</u></span>
                    <p id="product-description">Mô tả 12ả 123. Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/1.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món ngắn gọn 1 dòng</p>
                    <span id="product-price">30000 <u>đ</u></span>
                    <p id="product-description">Mô tả 12323. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.ô tả 123. Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/0.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món ngắn gọn 1 dòng</p>
                    <span id="product-price">30000 <u>đ</u></span>
                    <p id="product-description">Mô tả 12323. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.ô tả 123. Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-6">
            <div class="card" id="product">
                <div id="product-img">
                    <img class="card-img-top" src="{{ asset("/storage/images_product/items/1.png") }}" alt="product_img">
                </div>
                <div class="card-body" id="product-body">
                    <p id="product-name">Tên món ngắn gọn 1 dòng</p>
                    <span id="product-price">30000 <u>đ</u></span>
                    <p id="product-description">Mô tả 12323. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.  Mô tả 123. Mô tả 123. Mô tả 123.ô tả 123. Mô tả 123. Mô tả 123.</p>
                    <a id="product-add-btn" href="#" class="btn btn-success">Mua ngay</a>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('cart-btn')
    @include('frontend.partials.cart-btn')
@endsection