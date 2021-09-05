<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Frontend\CartModel;
use App\Models\Backend\OrdersModel;
use App\Models\Backend\OrderDetailsModel;


class PaymentController extends Controller
{
    //
    public function index() {

        $stores = DB::table('t_restaurants')
        ->where('Restaurant_SystemStatus', 1)
        ->where('Restaurant_OpenStatus', 1)
        ->get();

        $cart = new CartModel();
        $items = $cart->getAll();

        $auth = [];
        if (Auth::check()) {
            $auth['User_ID']=Auth::user()->id;
            $auth['Customer_Name']=Auth::user()->User_FullName;
            $auth['Customer_Email']=Auth::user()->User_Email;
            $auth['Customer_Phone']=Auth::user()->User_Phone;
            $auth['Customer_Address']=Auth::user()->User_Address;
        }

        $data = [];
        $data['auth'] = $auth;
        $data['stores'] = $stores;
        $data['items'] = $items;
        $data['totalPrice'] = $cart->getTotalPrice();

        return view('frontend.payment.payment', $data);
    }
    

    //
    public function checkout(Request $req) {
        
        // Validate dữ liệu
        $validatedData = $req->validate([
            'Restaurant_ID' => 'required',
            'Customer_Name' => 'required',
            'Customer_Phone' => 'required|min:10|max:13',
            'Customer_Address' => 'required',
        ]); 

        // Khai báo biến
        $cart = new CartModel();
        $restaurant = DB::table('t_restaurants')->select('Restaurant_Name')->find($req->input('Restaurant_ID'));
        $current=time();

        // Tạo ra mã theo dõi (tracking code) để tra cứu đơn hàng
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $TrackingCode = '';
        $TrackingCode .= date("His-", $current);
        for ($i = 0; $i < 4; $i++) {
            $TrackingCode .= $characters[rand(0, strlen($characters)-1)];
        }
        $TrackingCode .= "-";
        for ($i = 0; $i < 4; $i++) {
            $TrackingCode .= $characters[rand(0, strlen($characters)-1)];
        }
        $TrackingCode .= "-";
        for ($i = 0; $i < 4; $i++) {
            $TrackingCode .= $characters[rand(0, strlen($characters)-1)];
        }
        
        // Lưu thông tin tổng thể của đơn hàng vào database
        $order = new OrdersModel();
        $order->User_ID = $req->input('User_ID', "");
        $order->Customer_Name = $req->input('Customer_Name', "");
        $order->Customer_Phone = $req->input('Customer_Phone', "");
        $order->Customer_Email = $req->input('Customer_Email', "");
        $order->Customer_Address = $req->input('Customer_Address', "");
        $order->Restaurant_ID = $req->input('Restaurant_ID', "");
        $order->Order_RestaurantName = $restaurant->Restaurant_Name;
        $order->Order_TotalItem = $cart->getTotalItem();
        $order->Order_TotalQuantity = $cart->getTotalQuantity();
        $order->Order_TotalPrice = $cart->getTotalPrice();
        $order->Order_Note = $req->input('Order_Note', "");
        $order->Order_TrackingCode = $TrackingCode;
        $order->Order_Status = 1;
        $order->Order_Time_Request = date("Y-m-d H:i:s", $current);
        $order->created_user = $req->input('User_ID', "");
        $order->modified_user = $req->input('User_ID', "");
        $order->save();
        
        // Lưu các chi tiết của đơn hàng vào database
        $items = $cart->getAll();
        foreach ($items as $item) {
            $orderdetails = neW OrderDetailsModel();
            $orderdetails->Order_ID = $order->id;
            $orderdetails->Product_ID = $item["itemID"];
            $orderdetails->OrderDetail_ProductName = $item["itemName"];
            $orderdetails->OrderDetail_ProductPrice = (float)$item["itemPrice"];
            $orderdetails->OrderDetail_Quantity = (int)$item["itemQuantity"];
            $orderdetails->OrderDetail_TotalPrice = (float)$item["itemPrice"]*$item["itemQuantity"];
            $orderdetails->OrderDetail_Note = $item["itemNote"];
            $orderdetails->OrderDetail_Status = 1;
            $orderdetails->created_user = $req->input('User_ID', "");
            $orderdetails->modified_user = $req->input('User_ID', "");
            $orderdetails->save();
        }

        // Xóa hết thông tin giỏ hàng đang lưu trong session
        $clearCart = $cart->clearCart();

        // Gửi dữ liệu mã theo dõi tới view hoàn thành
        $data = [];
        $data['complete'] = "Completed!";
        $data['code'] = $TrackingCode;

        // Chuyển hướng tới view hoàn thành
        return redirect("/payment/complete")->with(['data' => $data]);
    }


    //
    public function complete() {

        $dataRaw=session()->get('data');

        if (isset($dataRaw)) {
            $checkcomplete = $dataRaw['complete'];
            $code = $dataRaw['code'];

            $data = [];
            $data['checkcomplete'] = $checkcomplete;
            $data['code'] = $code;

            return view('frontend.payment.complete', $data);
        }

        return view('frontend.payment.complete');
    }
}
