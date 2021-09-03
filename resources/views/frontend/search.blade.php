@extends('frontend.layouts.main')
@section('title', "Search")

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
                        <button id="product-add-btn"
                            class="btn btn-success open-modal {{ $product->Product_AvailableStatus!=2 ? 'disabled' : '' }}"
                            style="{{ $product->Product_AvailableStatus!=2 ? 'visibility: hidden' : '' }}"
                            value="{{ $product->id }}"
                            >Mua ngay
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="modal fade" id="CartModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>ADD TO CART</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- STORE ITEM TO CART -->
                    <form id="modalFormData" method="POST" action="{{ url('cart/store') }}">
                        @csrf
                        <div class="modal-body"> 
                            <input type="hidden" id="sessionID" name="sessionID" value="">
                            <input type="hidden" id="itemID" name="itemID" value="">
                            <input type="hidden" id="itemImage" name="itemImage" value="">
                            <div class="form-group col-md-12">
                                <label class="form-label">Tên sản phẩm:</label>
                                <input type="text" class="form-control" id="itemName" name="itemName" value="" readonly></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Giá sản phẩm:</label>
                                <input type="text" class="form-control" id="itemPrice" name="itemPrice" value="" readonly></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Số lượng:</label>
                                <select class="custom-select custom-select-sm" id="itemQuantity" name="itemQuantity">
                                    @for ($i = 1; $i <= 100; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Ghi chú:</label>
                                <input type="text" class="form-control" id="itemNote" name="itemNote" value="" placeholder="Type here..."></input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary StoreItem">Add</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

    </div>
@endsection

@section('cart-btn')
    @include('frontend.partials.cart-btn')
@endsection

@section('appendjs')
    <script type="text/javascript">
        $(document).ready(function() {

            // OPEN MODAL ADD TO CART
            $("body").on("click", ".open-modal", function () {
                var id = $(this).val();
                var url = "{{ url('/cart/add') }}"+"/";
                // console.log(id);
                $.get(url+id, function(data) {
                    // console.log(data);
                    let unique = new Date();
                    let sessionID = "id"+data.id+"session"+unique.valueOf();
                    $("#sessionID").val(sessionID);
                    $("#itemID").val(data.id);
                    $("#itemImage").val(data.Product_Img);
                    $("#itemName").val(data.Product_Name);
                    $("#itemPrice").val(data.Product_Price);
                    $("#itemQuantity").val(1);
                    $("#itemNote").val("");
                    $("#CartModal").modal("show");
                });
            });

            // STORE ITEM
            $("body").on("click", ".StoreItem", function () {
                var token = "{{ csrf_token() }}";
                var type = "POST";
                var formData = {
                    sessionID: $("#sessionID").val(),
                    itemID: $("#itemID").val(),
                    itemImage: $("#itemImage").val(),
                    itemName: $("#itemName").val(),
                    itemPrice: parseFloat($("#itemPrice").val()),
                    itemQuantity: parseInt($("#itemQuantity").val()),
                    itemNote: $("#itemNote").val(),
                    _token: token,
                }
                var ajaxurl = "{{ url('/cart/store/') }}";
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: "json",
                    success: function(data) {
                        alert("Thêm thành công! Vui lòng kiểm tra giỏ hàng!");
                        console.log(data.item);
                        $("#cart-btn-totalQuantity").html("");
                        $("#cart-btn-totalQuantity").append(data.totalQuantity);
                        $("#cart-btn-totalPrice").html("");
                        $("#cart-btn-totalPrice").append(data.totalPrice);
                        $("#modalFormData").trigger("reset");
                        $("#CartModal").modal("hide");
                    }
                });
            });

        });
    </script>
@endsection