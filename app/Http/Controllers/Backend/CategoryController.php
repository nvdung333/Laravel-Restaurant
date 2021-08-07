<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Backend\CategoriesModel;

class CategoryController extends Controller
{

    public function index() {
        
        // Lấy danh sách các category từ bảng t_categories
        $categories = DB::table('t_categories')->paginate(5);

        // Lấy ra tên parent category của category (nếu có)
        $parentcategories = DB::table('t_categories as t1', 't1.id as t1id')
                            ->select('t1.id as t1_id', 't2.Category_Name as t2_name')
                            ->leftjoin('t_categories as t2', 't1.Category_Parent_ID', '=', 't2.id')
                            ->get();

        // Truyền dữ liệu tới view
        $data = [];
        $data['categories'] = $categories;
        $data['parentcategories'] = $parentcategories;

        return view("backend.categories.index", $data);
    }


    public function details($id) {

        $category = CategoriesModel::findorFail($id);
        $parentcategories = CategoriesModel::all();

        // Truyền dữ liệu tới view
        $data = [];
        $data['category'] = $category;
        $data['parentcategories'] = $parentcategories;

        return view("backend.categories.details");
    }
    

    public function create() {

        // Lấy danh sách các category từ bảng t_categories và truyền tham số tới view
        $parentcategories = CategoriesModel::all();
        $data = [];
        $data['parentcategories'] = $parentcategories;

        return view("backend.categories.create", $data);
    }


    public function edit($id) {

        $category = CategoriesModel::findorFail($id);
        $parentcategories = CategoriesModel::all();

        // Truyền dữ liệu tới view
        $data = [];
        $data['category'] = $category;
        $data['parentcategories'] = $parentcategories;

        return view("backend.categories.edit", $data);
    }


    public function delete($id) {

        $category = CategoriesModel::findorFail($id);

        // Truyền dữ liệu tới view
        $data = [];
        $data['category'] = $category;

        return view("backend.categories.delete", $data);
    }


    public function store(Request $request) {
        
        // Validate dữ liệu
        $validatedData = $request->validate([
            'Category_Name' => 'required',
            'slug' => 'required',
        ]);

        
        // Dữ liệu request (từ view)
        $Category_Name = $request->input('Category_Name', "");
        $slug = $request->input('slug', "");
        $Category_Img = "";
        $Category_Description = $request->input('Category_Description', "");
        $Category_Parent_ID = $request->input('Category_Parent_ID', "");


        // Gán dữ liệu request cho các thuộc tính của $category
        $category = new CategoriesModel();

        $category->Category_Name = $Category_Name;
        $category->slug = $slug;
        $category->Category_Img = $Category_Img;
        $category->Category_Description = $Category_Description;
        $category->Category_Parent_ID = $Category_Parent_ID;
        $category->created_user = auth()->user()->id;
        $category->modified_user = auth()->user()->id;

        // Lưu và hoàn tất
        $category->save();

        // Chuyển hướng
        return redirect("/backend/category/index")->with('status', 'Thêm mới thành công!');
    }


    public function update(Request $request, $id) {
        
        // Validate dữ liệu
        $validatedData = $request->validate([
            'Category_Name' => 'required',
            'slug' => 'required',
        ]);

        // Dữ liệu request (từ view)
        $Category_Name = $request->input('Category_Name', "");
        $slug = $request->input('slug', "");
        $Category_Img = "";
        $Category_Description = $request->input('Category_Description', "");
        $Category_Parent_ID = $request->input('Category_Parent_ID', "");

        // Gán dữ liệu request cho các thuộc tính của $category
        $category = CategoriesModel::findorFail($id);

        $category->Category_Name = $Category_Name;
        $category->slug = $slug;
        $category->Category_Img = $Category_Img;
        $category->Category_Description = $Category_Description;
        $category->Category_Parent_ID = $Category_Parent_ID;
        $category->modified_user = auth()->user()->id;

        // Lưu và hoàn tất
        $category->save();

        // Chuyển hướng
        return redirect("/backend/category/edit/$id")->with('status', 'Cập nhật thành công!');
    }


    public function destroy(Request $request, $id) {
        
        // Lấy thông tin dữ liệu và xóa
        $category = CategoriesModel::findorFail($id);
        $category->delete();

        // Chuyển hướng
        return redirect("/backend/category/index")->with('status', 'Xóa thành công!');
    }

}
