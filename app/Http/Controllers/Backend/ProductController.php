<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Backend\ProductsModel;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request) {

        $search_keyword = $request->query('keyword', "");
        $whereCategory = (int)$request->query('whereCategory', "");
        $whereAvailableStatus = $request->query('whereAvailableStatus', "");
        $whereSystemStatus = $request->query('whereSystemStatus', "");
        $order_dir = $request->query('orderdir', "");

        // Lấy ra tất cả category
        $categories = DB::table('t_categories')->select()->get();

        // Lấy ra tất cả danh mục con
        $ChildCategories = [];
        foreach ($categories as $category) {
            if($category->Category_Parent_ID == $whereCategory)
            { $ChildCategories[] = $category->id; }
        }

        // Lệnh truy vấn gốc
        $queryORM = ProductsModel::where('Product_Name', 'LIKE', '%'.$search_keyword.'%');

        // Bổ sung thêm các phần lọc cho lệnh truy vấn gốc
        // Theo danh mục
        if ($whereCategory != "") {
            $queryORM->where(function ($query) use ($ChildCategories, $whereCategory) {
                $query->where('Category_ID', $whereCategory);
                foreach($ChildCategories as $ChildCategory)
                { $query->orWhere('Category_ID', $ChildCategory); }
            });
        }

        // Trạng thái bán
        if ($whereAvailableStatus != "") {
            $queryORM->where('Product_AvailableStatus', $whereAvailableStatus);
        }

        // Trạng thái khóa
        if ($whereSystemStatus == "1") {
            $queryORM->where('Product_SystemStatus', 1);
        }
        elseif ($whereSystemStatus == "0") {
            $queryORM->where('Product_SystemStatus', 0);
        }
        // Sắp xếp giá
        if ($order_dir == "ASC") {
            $queryORM->orderBy('Product_Price', 'ASC');
        }
        elseif ($order_dir == "DESC") {
            $queryORM->orderBy('Product_Price', 'DESC');
        }

        // Hoàn thành lệnh truy vấn
        $products = $queryORM->paginate(10)->withQueryString();

        // Lấy ra tên category của product (nếu có)
        $categoryofproducts = DB::table('t_products as t1')
        ->select('t1.id as t1_id', 't2.Category_Name as t2_name')
        ->leftjoin('t_categories as t2', 't1.Category_ID', '=', 't2.id')
        ->get();

        $data = [];
        $data['products'] = $products;
        $data['categories'] = $categories;
        $data['categoryofproducts'] = $categoryofproducts;
        $data["search_keyword"] = $search_keyword;
        $data["whereCategory"] = $whereCategory;
        $data["whereAvailableStatus"] = $whereAvailableStatus;
        $data["whereSystemStatus"] = $whereSystemStatus;
        $data["order_dir"] = $order_dir;

        return view("backend.products.index", $data);
    }


    public function create() {

        // Lấy danh sách các category từ bảng t_categories và truyền tham số tới view
        $categories = DB::table('t_categories')->select()->get();
        $data = [];
        $data['categories'] = $categories;

        return view("backend.products.create", $data);
    }


    public function edit($id) {

        $product = ProductsModel::findorFail($id);
        $categories = DB::table('t_categories')->select()->get();

        // Truyền dữ liệu tới view
        $data = [];
        $data['product'] = $product;
        $data['categories'] = $categories;

        return view("backend.products.edit", $data);
    }


    public function delete($id) {
        
        $product = ProductsModel::findorFail($id);

        // Truyền dữ liệu tới view
        $data = [];
        $data['product'] = $product;

        return view("backend.products.delete", $data);
    }


    public function store(Request $request) {

        // Validate dữ liệu
        $validatedData = $request->validate([
            'Category_ID' => 'required',
            'Product_Name' => 'required',
            'Product_Img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
            'Product_Price' => 'required|numeric',
        ]);
        
        // Dữ liệu request (từ view)
        $Category_ID = $request->input('Category_ID', "");
        $Product_Name = $request->input('Product_Name', "");
        $Product_Price = $request->input('Product_Price', "");
        $Product_Img = $request->file('Product_Img');
        $Product_Description = $request->input('Product_Description', "");

        // Lưu file ảnh (nếu có) vào thư mục
        if ($Product_Img != null)
        { $path_Product_Img = $request->file('Product_Img')->store('public/images_product'); }

        // Gọi model và gán các dữ liệu request
        $product = new ProductsModel();
        
        $product->Category_ID = $Category_ID;
        $product->Product_Name = $Product_Name;
        if ($Product_Img != null) { $product->Product_Img = $path_Product_Img; }
        $product->Product_Description = $Product_Description;
        $product->Product_Price = $Product_Price;
        $product->Product_AvailableStatus = 0;
        $product->Product_SystemStatus = 0;
        $product->created_user = auth()->user()->id;
        $product->modified_user = auth()->user()->id;
        
        // Lưu và hoàn tất
        $product->save();

        // Chuyển hướng
        return redirect("/backend/product/index")->with('status', 'Thêm mới thành công!');
    }


    public function update(Request $request, $id) {

        // Validate dữ liệu
        $validatedData = $request->validate([
            'Category_ID' => 'required',
            'Product_Name' => 'required',
            'Product_Img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3000',
            'Product_Price' => 'required|numeric',
            'Product_AvailableStatus' => 'required',
            'Product_SystemStatus' => 'required',
        ]);
        
        // Dữ liệu request (từ view)
        $Category_ID = $request->input('Category_ID', "");
        $Product_Name = $request->input('Product_Name', "");
        $Product_Price = $request->input('Product_Price', "");
        $Product_Img = $request->file('Product_Img');
        $Product_Description = $request->input('Product_Description', "");
        $Product_AvailableStatus = $request->input('Product_AvailableStatus', "");
        $Product_SystemStatus = $request->input('Product_SystemStatus', "");

        // Lưu file ảnh (nếu có) vào thư mục
        if ($Product_Img != null)
        { $path_Product_Img = $request->file('Product_Img')->store('public/images_product'); }

        // Gọi model và gán các dữ liệu request
        $product = ProductsModel::findorFail($id);
        
        $product->Category_ID = $Category_ID;
        $product->Product_Name = $Product_Name;
        if ($Product_Img != null) {
            Storage::delete($product->Product_Img);
            $product->Product_Img = $path_Product_Img;
        }
        $product->Product_Description = $Product_Description;
        $product->Product_Price = $Product_Price;
        $product->Product_AvailableStatus = $Product_AvailableStatus;
        $product->Product_SystemStatus = $Product_SystemStatus;
        $product->modified_user = auth()->user()->id;

        // Lưu và hoàn tất
        $product->save();

        // Chuyển hướng
        return redirect("/backend/product/info/$id")->with('status', 'Cập nhật thành công!');
    }


    public function destroy($id) {

        // Lấy thông tin dữ liệu và xóa
        $product = ProductsModel::findorFail($id);
        $product->delete();

        // Xóa ảnh, giải phóng dung lượng
        Storage::delete($product->Product_Img);

        // Chuyển hướng
        return redirect("/backend/product/index")->with('status', 'Xóa thành công!');
    }


    public function info($id) {
        
        $product = ProductsModel::findorFail($id);
        $categories = DB::table('t_categories')->select()->get();
        $users = DB::table('users')->select()->get();

        // Truyền dữ liệu tới view
        $data = [];
        $data['product'] = $product;
        $data['categories'] = $categories;
        $data['users'] = $users;

        return view("backend.products.info", $data);
    }
}
