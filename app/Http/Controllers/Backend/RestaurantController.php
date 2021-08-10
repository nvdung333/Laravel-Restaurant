<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Backend\l;

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

    }

    public function edit($id) {
        
    }

    public function delete($id) {
        
    }

    public function store(Request $request) {
        
    }

    public function update(Request $request, $id) {
        
    }

    public function destroy($id) {
        
    }

    public function info($id) {
        
    }
}

