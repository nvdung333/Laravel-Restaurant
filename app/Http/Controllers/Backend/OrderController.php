<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        // Hoàn thành lệnh truy vấn
        $orders = $queryORM->paginate(20)->withQueryString();

        // Đặt tên trạng thái để đưa lên view
        $status=[];
        $status[0] = "Cancel";
        $status[1] = "Request";
        $status[2] = "Accept";
        $status[3] = "Complete";
        $status[4] = "Receive";
        $status[5] = "Return";

        // Truyền dữ liệu tới view
        $data = [];
        $data['orders'] = $orders;
        $data['search_keyword'] = $search_keyword;
        $data['whereStatus'] = $whereStatus;
        $data['order_by'] = $order_by;
        $data['order_dir'] = $order_dir;
        $data['status'] = $status;

        return view('backend.orders.index', $data);
    }


    public function info(Request $request, $id) {

        $order = OrdersModel::findorFail($id);
        $orderdetails = OrderDetailsModel::select()->where('Order_ID', $id)->get();
        $users = DB::table('users')->select()->get();
        $restaurants = DB::table('t_restaurants')->get();

        dump($order);
        dump($request->request);

        // Đặt tên trạng thái để đưa lên view
        $status=[];
        $status[0] = "Cancel";
        $status[1] = "Request";
        $status[2] = "Accept";
        $status[3] = "Complete";
        $status[4] = "Receive";
        $status[5] = "Return";

        
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

        return redirect("/backend/order/info/$id")->with('status', 'Cập nhật trạng thái thành công!');
    }
}
