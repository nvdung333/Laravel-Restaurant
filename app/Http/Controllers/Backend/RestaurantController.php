<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Backend\RestaurantsModel;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function index(Request $request) {
        $search_keyword = $request->query('keyword', "");
        $whereArea = $request->query('whereArea', "");
        $whereOpenStatus = $request->query('whereOpenStatus', "");
        $whereSystemStatus = $request->query('whereSystemStatus', "");

        // Lấy ra tất cả area
        $array1_areas = DB::table('t_restaurants')->select('Restaurant_Area')->get();
        $array2_areas = []; foreach($array1_areas as $array1_area) { $array2_areas[] = $array1_area->Restaurant_Area; }
        $areas = array_unique($array2_areas);
        sort($areas);

        // Lệnh truy vấn gốc
        $queryORM = DB::table('t_restaurants')
        ->where(function ($query) use ($search_keyword) {
            $query->where('Restaurant_Name', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('Restaurant_Address', 'LIKE', '%'.$search_keyword.'%');
            $query->orWhere('Restaurant_Phone', 'LIKE', '%'.$search_keyword.'%');
        });

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Theo khu vực
        if ($whereArea != "")
        { $queryORM->where('Restaurant_Area', $whereArea); }

        // Trạng thái mở cửa
        if ($whereOpenStatus != "") {
            $queryORM->where('Restaurant_OpenStatus', $whereOpenStatus);
        }

        // Trạng thái khóa
        if ($whereSystemStatus == "1") {
            $queryORM->where('Restaurant_SystemStatus', 1);
        }
        elseif ($whereSystemStatus == "0") {
            $queryORM->where('Restaurant_SystemStatus', 0);
        }

        // Hoàn thành lệnh truy vấn
        $restaurants = $queryORM->paginate(10)->withQueryString();

        $data = [];
        $data['restaurants'] = $restaurants;
        $data['areas'] = $areas;
        $data["search_keyword"] = $search_keyword;
        $data["whereArea"] = $whereArea;
        $data["whereOpenStatus"] = $whereOpenStatus;
        $data["whereSystemStatus"] = $whereSystemStatus;

        return view("backend.restaurants.index", $data);
    }

    public function create() {

        return view("backend.restaurants.create");
    }

    public function edit($id) {

        $restaurant = RestaurantsModel::findorFail($id);

        // Truyền dữ liệu tới view
        $data = [];
        $data['restaurant'] = $restaurant;

        return view("backend.restaurants.edit", $data);
    }

    public function delete($id) {

        $restaurant = RestaurantsModel::findorFail($id);

        // Truyền dữ liệu tới view
        $data = [];
        $data['restaurant'] = $restaurant;

        return view("backend.restaurants.delete", $data);
    }

    public function store(Request $request) {
        
        // Validate dữ liệu
        $validatedData = $request->validate([
            'Restaurant_Name' => 'required',
            'Restaurant_Address' => 'required',
            'Restaurant_Area' => 'required',
            'Restaurant_Phone' => 'required',
        ]);

        // Dữ liệu request (từ view)
        $Restaurant_Name = $request->input('Restaurant_Name', "");
        $Restaurant_Address = $request->input('Restaurant_Address', "");
        $Restaurant_Area = $request->input('Restaurant_Area', "");
        $Restaurant_Phone = $request->input('Restaurant_Phone', "");
        $Restaurant_Description = $request->input('Restaurant_Description', "");
        
        // Gọi model và gán các dữ liệu request
        $restaurant = new RestaurantsModel();

        $restaurant->Restaurant_Name = $Restaurant_Name;
        $restaurant->Restaurant_Address = $Restaurant_Address;
        $restaurant->Restaurant_Area = $Restaurant_Area;
        $restaurant->Restaurant_Phone = $Restaurant_Phone;
        $restaurant->Restaurant_Description = $Restaurant_Description;
        $restaurant->Restaurant_OpenStatus = 0;
        $restaurant->Restaurant_SystemStatus = 0;
        $restaurant->created_user = auth()->user()->id;
        $restaurant->modified_user = auth()->user()->id;

        // Lưu và hoàn tất
        $restaurant->save();

        // Chuyển hướng
        return redirect("/backend/restaurant/index")->with('status', 'Thêm mới thành công!');
    }

    public function update(Request $request, $id) {

        // Validate dữ liệu
        $validatedData = $request->validate([
            'Restaurant_Name' => 'required',
            'Restaurant_Address' => 'required',
            'Restaurant_Area' => 'required',
            'Restaurant_Phone' => 'required',
            'Restaurant_OpenStatus' => 'required',
            'Restaurant_SystemStatus' => 'required',
        ]);

        // Dữ liệu request (từ view)
        $Restaurant_Name = $request->input('Restaurant_Name', "");
        $Restaurant_Address = $request->input('Restaurant_Address', "");
        $Restaurant_Area = $request->input('Restaurant_Area', "");
        $Restaurant_Phone = $request->input('Restaurant_Phone', "");
        $Restaurant_Description = $request->input('Restaurant_Description', "");
        $Restaurant_OpenStatus = $request->input('Restaurant_OpenStatus', "");
        $Restaurant_SystemStatus = $request->input('Restaurant_SystemStatus', "");
        
        // Gọi model và gán các dữ liệu request
        $restaurant = RestaurantsModel::findorFail($id);

        $restaurant->Restaurant_Name = $Restaurant_Name;
        $restaurant->Restaurant_Address = $Restaurant_Address;
        $restaurant->Restaurant_Area = $Restaurant_Area;
        $restaurant->Restaurant_Phone = $Restaurant_Phone;
        $restaurant->Restaurant_Description = $Restaurant_Description;
        $restaurant->Restaurant_OpenStatus = $Restaurant_OpenStatus;
        $restaurant->Restaurant_SystemStatus = $Restaurant_SystemStatus;
        $restaurant->modified_user = auth()->user()->id;

        // Lưu và hoàn tất
        $restaurant->save();

        // Chuyển hướng
        return redirect("/backend/restaurant/info/$id")->with('status', 'Cập nhật thành công!');
    }

    public function destroy($id) {

        // Lấy thông tin dữ liệu và xóa
        $restaurant = RestaurantsModel::findorFail($id);
        $restaurant->delete();

        // Chuyển hướng
        return redirect("/backend/restaurant/index")->with('status', 'Xóa thành công!');
    }

    public function info($id) {
        
        $restaurant = RestaurantsModel::findorFail($id);
        $users = DB::table('users')->select()->get();

        // Truyền dữ liệu tới view
        $data = [];
        $data['restaurant'] = $restaurant;
        $data['users'] = $users;

        return view("backend.restaurants.info", $data);
    }
}
