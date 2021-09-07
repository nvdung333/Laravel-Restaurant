<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\OrdersModel;
use App\Models\Backend\OrderDetailsModel;

class OrderController extends Controller
{
    public function index(Request $request) {

        $search_keyword = $request->query('keyword', "");
        $whereStatus = $request->query('whereStatus', "");
        $order_by = $request->query('orderby', "");
        $order_dir = $request->query('orderdir', "");

        $whereBetween = $request->query('whereBetween', "Order_Time_Request");
        $time_start = $request->query('time_start', "");
        $time_end = $request->query('time_end', "");
        $now = date('Y-m-d H:i:s');

        // Mảng báo lỗi
        $customErrors=[];

        // Lệnh truy vấn gốc
        $queryORM = OrdersModel::select()
        ->where(function ($query) use ($search_keyword) {
            $query->where('Order_TrackingCode', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('Customer_Phone', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('Customer_Email', 'LIKE', '%'.$search_keyword.'%');
        });

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Theo trạng thái
        if ($whereStatus != "") {
            $queryORM->where('Order_Status', $whereStatus);
        }
        // Sắp xếp theo hướng
        if ($order_dir == "ASC") {
            if ($order_by != "")
            { $queryORM->orderBy($order_by, "asc"); }
            else { $queryORM->orderBy('id', "asc"); }
        }
        elseif ($order_dir == "DESC") {
            if ($order_by != "")
            { $queryORM->orderBy($order_by, "desc"); }
            else { $queryORM->orderBy('id', "desc"); }
        }
        else {
            if ($order_by != "")
            { $queryORM->orderBy($order_by, "desc"); }
        }
        // Sắp xếp truy vấn gốc
        $queryORM->orderBy('id', 'desc');
        // Sắp xếp trong khoảng thời gian
        if ($time_start!="" and $time_end!="") {
            if ($time_start > $now or $time_end > $now) {
                $customErrors[]="Thời gian đã chọn đang lớn hơn thời gian hiện tại.";
            }
            if ($time_start > $time_end) {
                $customErrors[]="Thời gian bắt đầu phải sớm hơn Thời gian kết thúc.";
            }
            $queryORM->whereBetween($whereBetween, [$time_start, $time_end]);
        }
        elseif ($time_start!="" && $time_end=="") {
            if ($time_start > $now) {
                $customErrors[]="Thời gian đã chọn đang lớn hơn thời gian hiện tại.";
            }
            $queryORM->where($whereBetween, '>=', $time_start);
        }
        elseif ($time_start=="" && $time_end!="") {
            if ($time_end > $now) {
                $customErrors[]="Thời gian đã chọn đang lớn hơn thời gian hiện tại.";
            }
            $queryORM->where($whereBetween, '<=', $time_end);
        }

        // Hoàn thành lệnh truy vấn
        $orders = $queryORM->paginate(20)->withQueryString();

        // Đặt tên trạng thái để đưa lên view
        $status=[];
        $status[0] = "Hủy";
        $status[1] = "Đang yêu cầu";
        $status[2] = "Chấp nhận yêu cầu";
        $status[3] = "Đã xong/Đang giao";
        $status[4] = "Giao nhận xong";
        $status[5] = "Trả lại";

        // Truyền dữ liệu tới view
        $data = [];
        $data['orders'] = $orders;
        $data['search_keyword'] = $search_keyword;
        $data['whereStatus'] = $whereStatus;
        $data['order_by'] = $order_by;
        $data['order_dir'] = $order_dir;
        $data['whereBetween'] = $whereBetween;
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['status'] = $status;
        $data['customErrors'] = $customErrors;

        return view('backend.orders.index', $data);
    }


    public function info(Request $request, $id) {

        $order = OrdersModel::findorFail($id);
        $orderdetails = OrderDetailsModel::select()->where('Order_ID', $id)->get();
        $users = DB::table('users')->select()->get();
        $restaurants = DB::table('t_restaurants')->get();

        $Restaurant_ID = $request->input('Restaurant_ID', "");
        if ($Restaurant_ID != "") {
            $query = DB::table('t_restaurants')->find($Restaurant_ID);
            $Order_RestaurantName = $query->Restaurant_Name;
        }

        // Lưu thông tin cập nhật vào database (nếu có request Update)
        if (isset($request) && !empty($request->toarray())) {
            $orderUpdate = OrdersModel::findorFail($id);
            $orderUpdate->Customer_Address = $request->input('Customer_Address', "");
            $orderUpdate->Restaurant_ID = $request->input('Restaurant_ID', "");
            if(isset($Order_RestaurantName))
            { $orderUpdate->Order_RestaurantName = $Order_RestaurantName; }
            $orderUpdate->Restaurant_Staff = $request->input('Restaurant_Staff', "");
            $orderUpdate->save();
            return redirect("/backend/order/info/$id")->with('status', 'Cập nhật thông tin thành công!');
        }

        // Đặt tên trạng thái để đưa lên view
        $status=[];
        $status[0] = "Hủy";
        $status[1] = "Đang yêu cầu";
        $status[2] = "Chấp nhận yêu cầu";
        $status[3] = "Đã xong/Đang giao";
        $status[4] = "Giao nhận xong";
        $status[5] = "Trả lại";

        
        $customErrors=[];

        // Truyền dữ liệu tới view
        $data = [];
        $data['order'] = $order;
        $data['orderdetails'] = $orderdetails;
        $data['users'] = $users;
        $data['restaurants'] = $restaurants;
        $data['status'] = $status;
        $data['customErrors'] = $customErrors;

        return view("backend.orders.info", $data);
    }


    public function status(Request $request, $id) {

        $Order_Status = (int)$request->input('Order_Status', "");
        $Order_CancelReason = $request->input('Order_CancelReason', "");
        $Order_ReturnReason = $request->input('Order_ReturnReason', "");
        $now = date('Y-m-d H:i:s');

        if ($Order_Status == 1) {
            $order = OrdersModel::findorFail($id);
            $order->Order_Status = 1;
            $order->Order_Time_Request = $now;
            $order->Order_Time_Accept = null;
            $order->Order_Time_Complete = null;
            $order->Order_Time_Receive = null;
            $order->save();
        }

        if ($Order_Status == 2) {
            $order = OrdersModel::findorFail($id);
            $order->Order_Status = 2;
            $order->Order_Time_Accept = $now;
            $order->Order_Time_Complete = null;
            $order->Order_Time_Receive = null;
            $order->save();
        }

        if ($Order_Status == 3) {
            $order = OrdersModel::findorFail($id);
            $order->Order_Status = 3;
            $order->Order_Time_Complete = $now;
            $order->Order_Time_Receive = null;
            $order->save();
        }

        if ($Order_Status == 4) {
            $order = OrdersModel::findorFail($id);
            $order->Order_Status = 4;
            $order->Order_Time_Receive = $now;
            $order->save();
        }

        if ($Order_Status == 5) {
            $order = OrdersModel::findorFail($id);
            $order->Order_Status = 5;
            $order->Order_Time_Return = $now;
            $order->Order_ReturnReason = $Order_ReturnReason;
            $order->save();
        }

        if ($Order_Status == 0) {
            $order = OrdersModel::findorFail($id);
            $order->Order_Status = 0;
            $order->Order_Time_Cancel = $now;
            $order->Order_CancelReason = $Order_CancelReason;
            $order->Order_CancelBy = Auth::user()->User_FullName;
            $order->save();
        }

        return redirect("/backend/order/info/$id")->with('status', 'Cập nhật trạng thái thành công!');
    }
}
