<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartModel extends Model
{
    use HasFactory;

    public function getAll() {
        $cart = [];
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }
        return $cart;
    }


    public function getTotalItem() {
        $totalItem = 0;
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $array = [];
            foreach($cart as $item) {
                $array[] = $item["itemID"];
            }
            $totalItem = count(array_unique($array));
        }
        return $totalItem;
    }

    public function getTotalQuantity() {
        $totalQtt = 0;
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $array = [];
            foreach($cart as $item) {
                $array[] = (int)$item["itemQuantity"];
            }
            $totalQtt = array_sum($array);
        }
        return $totalQtt;
    }

    public function getTotalPrice() {
        $totalPrice = 0;
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $array = [];
            foreach($cart as $item) {
                $price = (float)$item['itemPrice'];
                $quantity = (int)$item['itemQuantity'];
                $array[] = $price*$quantity;
            }
            $totalPrice = array_sum($array);
        }
        return $totalPrice;
    }


    // STORE TO CART
    public function storeCart($dataRaw) {
        $items = [];
        $id = $dataRaw['sessionID'];
        $items['sessionID'] = $dataRaw['sessionID'];
        $items['itemID'] = $dataRaw['itemID'];
        $items['itemImage'] = $dataRaw['itemImage'];
        $items['itemName'] = $dataRaw['itemName'];
        $items['itemPrice'] = $dataRaw['itemPrice'];
        $items['itemQuantity'] = $dataRaw['itemQuantity'];
        $items['itemNote'] = $dataRaw['itemNote'];

        $cart = Session::get('cart');
        $cart[$id] = $items;
        Session::put('cart', $cart);
        return $cart[$id];
    }


    // UPDATE CART
    public function updateCart($dataRaw, $id) {
        $cart = [];
        if(Session::has('cart'))
        {
            $cart = Session::get('cart');
            $newQtt = (int)$dataRaw['newQtt'];
            $items = [];
            foreach ($cart as $item) {
                if ($item['sessionID'] == $id) {
                    $item['itemQuantity'] = $newQtt;
                    $items = $item;
                }
            }
            $cart[$id] = $items;
            Session::put('cart', $cart);
        }
        return $cart;
    }


    // REMOVE ITEM FROM CART
    public function removeCart($id) {
        $cart = [];
        if(Session::has('cart'))
        {
            $cart = Session::get('cart');
            $items = [];
            foreach ($cart as $item) {
                if ($item['sessionID'] != $id) {
                    $items[] = $item;
                }
            }
            Session::forget('cart');
            $cart = Session::get('cart');
            foreach ($items as $item) {
                $cart[$item['sessionID']] = $item;
                Session::put('cart', $cart);
            }
        }
        return $cart;
    }


    // CLEAR CART
    public function clearCart() {
        if(Session::has('cart'))
        {
            Session::pull('cart');
        }
    }
    
}
