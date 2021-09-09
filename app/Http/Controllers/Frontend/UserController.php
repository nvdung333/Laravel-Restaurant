<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Backend\OrdersModel;
use App\Models\Backend\OrderDetailsModel;

class UserController extends Controller
{
    // 
    public function historyIndex () {

        $user_ID = Auth::User()->id;
        $orders = OrdersModel::where('User_ID', $user_ID)
        ->orderBy('id', 'desc')->paginate(20)->withQueryString();
        $status=[];
        $status[0] = "Hủy đơn";
        $status[1] = "Đang yêu cầu";
        $status[2] = "Chấp nhận/Đang làm";
        $status[3] = "Đã xong/Đang giao";
        $status[4] = "Giao nhận xong";
        $status[5] = "Trả lại";
        
        $data = [];
        $data['orders'] = $orders;
        $data['status'] = $status;

        return view('frontend.user.historyIndex', $data);
    }


    // 
    public function historyInfo (Request $request, $id) {

        $user_ID = Auth::User()->id;
        $order = OrdersModel::findorfail($id);
        $orderdetails = OrderDetailsModel::where('Order_ID', $id)->get();
  
        $Order_Status = (int)$request->input('Order_Status', "");
        $Order_CancelReason = $request->input('Order_CancelReason', "");
        $Order_ReturnReason = $request->input('Order_ReturnReason', "");
        $now = date('Y-m-d H:i:s');

        if (isset($request) && $request->toarray()!=null)
        {
            // Hủy đơn
            if ($Order_Status == 0) {
                $order = OrdersModel::findorFail($id);
                $order->Order_Status = 0;
                $order->Order_Time_Cancel = $now;
                $order->Order_CancelReason = $Order_CancelReason;
                $order->Order_CancelBy = Auth::user()->User_FullName;
                $order->modified_user = auth()->user()->id;
                $order->save();
                $query = OrderDetailsModel::where('Order_ID', $id)->get();
                foreach ($query as $value) {
                    $orderdetails = OrderDetailsModel::findorFail($value->id);
                    $orderdetails->OrderDetail_Status = 0;
                    $orderdetails->modified_user = auth()->user()->id;
                    $orderdetails->save();
                }
                return redirect("/user/history/$id")->with('status', 'Đã yêu cầu hủy đơn!');
            }

            // Trả lại
            if ($Order_Status == 5) {
                $order = OrdersModel::findorFail($id);
                $order->Order_Status = 5;
                $order->Order_Time_Return = $now;
                $order->Order_ReturnReason = $Order_ReturnReason;
                $order->modified_user = auth()->user()->id;
                $order->save();
                $query = OrderDetailsModel::where('Order_ID', $id)->get();
                foreach ($query as $value) {
                    $orderdetails = OrderDetailsModel::findorFail($value->id);
                    $orderdetails->OrderDetail_Status = 5;
                    $orderdetails->modified_user = auth()->user()->id;
                    $orderdetails->save();
                }
                return redirect("/user/history/$id")->with('status', 'Đã yêu cầu trả lại!');
            }
        }

        $status=[];
        $status[0] = "Hủy đơn";
        $status[1] = "Đang yêu cầu";
        $status[2] = "Chấp nhận/Đang làm";
        $status[3] = "Đã xong/Đang giao";
        $status[4] = "Giao nhận xong";
        $status[5] = "Trả lại";

        $data = [];

        if ($user_ID == $order->User_ID) {
            $data['order'] = $order;
            $data['orderdetails'] = $orderdetails;
            $data['status'] = $status;
        }
        else {
            abort(403);
        }

        return view('frontend.user.historyInfo', $data);
    }
}
