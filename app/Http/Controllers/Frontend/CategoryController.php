<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function index($id, $slug=null) {
        
        $query = DB::table('t_categories')->find($id);
        if ($query == null) {
            abort (404);
        }
        else {
            $title = $query->Category_Name;
            $checkSystemStatus = $query->Category_SystemStatus;
            $checkslug = $query->Category_Slug;
            $parent_id = (int)$query->Category_Parent_ID;
        }
        
        // Kiểm tra trạng thái khóa
        if ($checkSystemStatus == 0) {
            abort (403);
        }
        // Kiểm tra trạng thái khóa của danh mục parent (nếu có)
        $query1 = DB::table('t_categories')->select('Category_SystemStatus')->find($parent_id);
        if ($query1 != null) {
            if ($query1->Category_SystemStatus == 0) {
                abort (403);
            }       
        }

        // Lấy ra mảng chứa ID các danh mục child
        $array_child_id = [];
        $query2 = DB::table('t_categories')->where('Category_Parent_ID', $id)->get();
        foreach ($query2 as $value) {
            $array_child_id[] = $value->id;
        }
        // Lấy ra mảng chứa ID các danh mục child không bị khóa
        $array_valid_child_id = [];
        if ($array_child_id != null) {
            foreach ($array_child_id as $value) {
                $query = DB::table('t_categories')->where('Category_SystemStatus', 1)->find($value);
                if ($query != null) {
                    $array_valid_child_id[] = $query->id;
                }
            }
        }

        // Nếu URL không có slug => xuất dữ liệu như bình thường
        if ($slug == "") {
            $query3 = DB::table('t_products')->select();
            $query3->where(function ($query) use ($id, $array_valid_child_id) {
                $query->where('Category_ID', $id);
                if ($array_valid_child_id != null) {
                    foreach ($array_valid_child_id as $valid_child_id) {
                        $query->orWhere('Category_ID', $valid_child_id);
                    }
                }
            });
            $query3->where('Product_SystemStatus', 1);
            $products = $query3->get();
        }
        // Nếu URL chứa slug => kiểm tra có đúng slug trên database hay ko rồi mới xuất dữ liệu
        else {
            if ($checkslug == $slug) {
                $query3 = DB::table('t_products')->select();
                $query3->where(function ($query) use ($id, $array_valid_child_id) {
                    $query->where('Category_ID', $id);
                    if ($array_valid_child_id != null) {
                        foreach ($array_valid_child_id as $valid_child_id) {
                            $query->orWhere('Category_ID', $valid_child_id);
                        }
                    }
                });
                $query3->where('Product_SystemStatus', 1);
                $products = $query3->get();
            }
            else {
                abort(404);
            }
        }


        $data=[];
        $data['products'] = $products;
        $data['title'] = $title;

        return view('frontend.order', $data);
    }
}
