<div id="cart-btn">
    <a class="btn" href="{{ url('cart') }}">
        <div class="row">
            <div class="col-6">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-btn-title"> Xem giỏ hàng</span>
                <span id="cart-btn-totalQuantity">{{$totalQuantity}}</span>
            </div>
            <div class="col-6"><span id="cart-btn-totalPrice">{{$totalPrice}}</span> VNĐ</div>
        </div>
    </a>
</div>