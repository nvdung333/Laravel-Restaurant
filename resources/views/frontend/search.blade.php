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
                    <div class="modal-body"> 
                        <form id="modalFormData" name="modalFormData" class="form-horizontal">
                            @csrf
                            <div class="form-group col-md-12">
                                <label class="form-label">Name:</label>
                                <input type="text" class="form-control" id="Product_Name" name="Product_Name" value="" readonly></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Price:</label>
                                <input type="text" class="form-control" id="Product_Price" name="Product_Price" value="" readonly></input>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Quantity:</label>
                                <select class="custom-select custom-select-sm" id="Product_Quantity" name="Product_Quantity">
                                    @for ($i = 1; $i <= 100; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Note:</label>
                                <input type="text" class="form-control" id="Product_Note" name="" value="" placeholder="Type here..."></input>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btn-save" value="">Add</button>
                        <input type="hidden" id="Product_ID" name="Product_ID" value="">
                    </div>
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
                var url = "{{ url('/openmodal/order') }}"+"/";
                // console.log(id);
                $.get(url+id, function(data) {
                    // console.log(data);
                    $("#Product_Name").val(data.Product_Name);
                    $("#Product_Price").val(data.Product_Price);
                    $("#Product_Note").val("");
                    $("#Product_ID").val(data.id);
                    $("#CartModal").modal("show");
                });
            });
        });
    </script>
@endsection