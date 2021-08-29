<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    //
    public function index(){

        $query = DB::table('t_restaurants')->where('Restaurant_SystemStatus', 1)->get();
        $restaurants = $query;

        $all_areas=[]; foreach($query as $value) { $all_areas[] = $value->Restaurant_Area; }
        $unique_areas = array_unique($all_areas);
        sort($unique_areas);

        $data = [];
        $data['restaurants'] = $restaurants;
        $data['areas'] = $unique_areas;

        return view("frontend.find-us", $data);
    }
}
