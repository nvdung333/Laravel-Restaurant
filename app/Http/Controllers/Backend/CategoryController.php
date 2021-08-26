<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Backend\CategoriesModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request) {
        
        $search_keyword = $request->query('keyword', "");
        $order_by = $request->query('orderby', "");
        $order_dir = $request->query('orderdir', "");

        // Truy vấn danh sách Id để tìm kiếm nhóm cha
        $array_ParentCategories = CategoriesModel::select('id')->where('Category_Name', 'LIKE', '%'.$search_keyword.'%')->get();
        $id_ParentCategories = [];
        foreach ($array_ParentCategories as $array_ParentCategory)
        { $id_ParentCategories[] = $array_ParentCategory->id; }

        // Lệnh truy vấn gốc
        $queryORM = CategoriesModel::where('Category_Name', 'LIKE', '%'.$search_keyword.'%');

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        foreach ($id_ParentCategories as $id_ParentCategory)
        { $queryORM->orwhere('Category_Parent_ID', 'LIKE', $id_ParentCategory); }

        if ($order_dir == "ASC") {
            if ($order_by != "")
            { $queryORM->orderBy($order_by, 'ASC'); }
            else { $queryORM->orderBy('id', 'ASC'); }
        }
        elseif ($order_dir == "DESC") {
            if ($order_by != "")
            { $queryORM->orderBy($order_by, 'DESC'); }
            else { $queryORM->orderBy('id', 'DESC'); }
        }
        else
        {
            if ($order_by != "")
            { $queryORM->orderBy($order_by); }
            else { $queryORM->orderBy('id'); }
        }

        // Hoàn thành lệnh truy vấn
        $categories = $queryORM->paginate(5)->withQueryString();

        // Lấy ra tên parent category của category (nếu có)
        $parentcategories = DB::table('t_categories as t1')
        ->select('t1.id as t1_id', 't2.Category_Name as t2_name')
        ->leftjoin('t_categories as t2', 't1.Category_Parent_ID', '=', 't2.id')
        ->get();

        // Truyền dữ liệu tới view
        $data = [];
        $data['categories'] = $categories;
        $data['parentcategories'] = $parentcategories;
        $data["search_keyword"] = $search_keyword;
        $data["order_by"] = $order_by;
        $data["order_dir"] = $order_dir;

        return view("backend.categories.index", $data);
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
            'Category_Img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
        ]);

        
        // Dữ liệu request (từ view)
        $Category_Name = $request->input('Category_Name', "");
        $Category_Slug = Str::slug($request->input('Category_Name', ""));
        $Category_Img = $request->file('Category_Img');
        $Category_Description = $request->input('Category_Description', "");
        $Category_Parent_ID = $request->input('Category_Parent_ID', "");

        // Lưu file ảnh (nếu có) vào thư mục
        if ($Category_Img != null)
        { $path_Category_Img = $request->file('Category_Img')->store('public/images_category'); }

        // Gọi model và gán các dữ liệu request
        $category = new CategoriesModel();

        $category->Category_Name = $Category_Name;
        $category->Category_Slug = $Category_Slug;
        if ($Category_Img != null) { $category->Category_Img = $path_Category_Img; }
        $category->Category_Description = $Category_Description;
        $category->Category_Parent_ID = $Category_Parent_ID;
        $category->Category_SystemStatus = 0;
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
            'Category_Slug' => 'required',
            'Category_Img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
            'Category_SystemStatus' => 'required',
        ]);

        // Dữ liệu request (từ view)
        $Category_Name = $request->input('Category_Name', "");
        $Category_Slug = $request->input('Category_Slug', "");
        $Category_Img = $request->file('Category_Img');
        $Category_Description = $request->input('Category_Description', "");
        $Category_Parent_ID = $request->input('Category_Parent_ID', "");
        $Category_SystemStatus = $request->input('Category_SystemStatus', "");

        // Lưu file ảnh (nếu có) vào thư mục
        if ($Category_Img != null)
        { $path_Category_Img = $request->file('Category_Img')->store('public/images_category'); }

        // Gọi model và gán các dữ liệu request
        $category = CategoriesModel::findorFail($id);

        $category->Category_Name = $Category_Name;
        $category->Category_Slug = $Category_Slug;
        if ($Category_Img != null) {
            Storage::delete($category->Category_Img);
            $category->Category_Img = $path_Category_Img;
        }
        $category->Category_Description = $Category_Description;
        $category->Category_Parent_ID = $Category_Parent_ID;
        $category->Category_SystemStatus = $Category_SystemStatus;
        $category->modified_user = auth()->user()->id;

        // Lưu và hoàn tất
        $category->save();

        // Chuyển hướng
        return redirect("/backend/category/info/$id")->with('status', 'Cập nhật thành công!');
    }


    public function destroy($id) {
        
        // Lấy thông tin dữ liệu và xóa
        $category = CategoriesModel::findorFail($id);
        $category->delete();

        // Xóa ảnh, giải phóng dung lượng
        Storage::delete($category->Category_Img);

        // Chuyển hướng
        return redirect("/backend/category/index")->with('status', 'Xóa thành công!');
    }


    public function info($id) {

        $category = CategoriesModel::findorFail($id);
        $parentcategories = CategoriesModel::all();
        $users = DB::table('users')->select()->get();

        // Truyền dữ liệu tới view
        $data = [];
        $data['category'] = $category;
        $data['parentcategories'] = $parentcategories;
        $data['users'] = $users;

        return view("backend.categories.info", $data);
    }
}
