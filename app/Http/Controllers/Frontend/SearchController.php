<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //
    public function index(Request $request) {

        $search_keyword = $request->query('keyword', "");

        // Lấy ra mảng chứa các danh mục hợp lệ, không bị khóa
        $categories = [];
        $query1 = DB::table('t_categories')->where('Category_SystemStatus', 1)->get();
        foreach ($query1 as $value) {
            $query2 = DB::table('t_categories')->select('id','Category_SystemStatus')
            ->where('id', $value->Category_Parent_ID)->find($value->Category_Parent_ID);

            if ($query2 == null) { $categories[] = $value->id; }
            elseif ($query2->Category_SystemStatus == 1) { $categories[] = $value->id; }
        }

        // Lệnh truy vấn
        $query3 = DB::table('t_products')->where('Product_Name', 'LIKE', '%'.$search_keyword.'%');
        $query3->where(function ($query) use ($categories) {
            $query->where('Category_ID', "");
            foreach ($categories as $category_id) {
                $query->orWhere('Category_ID', $category_id);
            }
        });
        // $query3->whereIn('Product_AvailableStatus', [1,2]);
        $query3->where('Product_SystemStatus', 1);

        // Hoàn thành truy vấn
        $products = $query3->orderby('Product_Price', 'desc')->get();

        // Truyền biến
        $data['products'] = $products;
        $data['search_keyword'] = $search_keyword;
        
        return view('frontend.search', $data);
    }
    
    public function openmodal($id) {
        $products = DB::table('t_products')->find($id);
        return response()->json($products);
    }
}
