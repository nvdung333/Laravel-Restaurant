<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Frontend\CartModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    //
    public function shareKey() {
        $cart = new CartModel();
        $totalItem = $cart->getTotalItem();
        $totalQuantity = $cart->getTotalQuantity();
        $totalPrice = $cart->getTotalPrice();
        view()->share('totalItem', $totalItem);
        view()->share('totalQuantity', $totalQuantity);
        view()->share('totalPrice', $totalPrice);
    }

    // SHOW CART
    public function index() {
        $this->shareKey();
        $cart = new CartModel();
        $cart = $cart->getAll();
        $data = [];
        $data['items'] = $cart;
        return view('frontend.cart', $data);
    }


    // ADD ITEM TO CART
    public function add($id) {
        $products = DB::table('t_products')->find($id);
        return response()->json($products);
    }


    // STORE TO CART
    public function store(Request $request) {
        $cart = new CartModel();
        $dataReq = $request->all();
        $item = $cart->storeCart($dataReq);
        $data=[];
        $data['item'] = $item;
        $data['totalQuantity']=$cart->getTotalQuantity();
        $data['totalPrice']=$cart->getTotalPrice();
        return Response::json($data);
    }


    // UPDATE CART
    public function update(Request $request, $id) {
        $cart = new CartModel();
        $dataReq = $request->all();
        $data = $cart->updateCart($dataReq, $id);
        return Response::json($data);
    }


    // REMOVE ITEM FROM CART
    public function remove($id) {
        $cart = new CartModel();
        $data = $cart->removeCart($id);
        return Response::json($data);
    }
    

    // CLEAR CART
    public function clear() {
        $cart = new CartModel();
        $cart->clearCart();
        return redirect('cart');
    }
}
