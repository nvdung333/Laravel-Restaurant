<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{
    //
    public function index(Request $request) {

        $track_keyword = $request->input('keyword', "");

        $query = DB::table('t_orders')->select('id')
        ->where('Order_TrackingCode', $track_keyword)->get()->toArray();
        if ($query != null) {
            $id = $query[0]->id;
        }

        $order=[];
        $orderdetails=[];
        if (isset($id)) {
            $order = DB::table('t_orders')->where('Order_TrackingCode', $track_keyword)->find($id);
            $orderdetails = DB::table('t_orderdetails')->where('Order_ID', $id)->get();
        }

        $orderstatus=[];
        $orderstatus[0] = "Hủy";
        $orderstatus[1] = "Đang yêu cầu";
        $orderstatus[2] = "Chấp nhận yêu cầu";
        $orderstatus[3] = "Đã xong/Đang giao";
        $orderstatus[4] = "Giao nhận xong";
        $orderstatus[5] = "Trả lại";
        
        $data = [];
        $data['track_keyword'] = $track_keyword;
        $data['order'] = $order;
        $data['orderstatus'] = $orderstatus;
        $data['orderdetails'] = $orderdetails;

        return view("frontend.track", $data);
    }
}
