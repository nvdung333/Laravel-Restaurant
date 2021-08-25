@extends('backend.layouts.main')
@section('title', 'Categories')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách các danh mục hàng hóa</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Report</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div style="padding-bottom: 10px">
        <a href="{{ url("/backend/category/create") }}" class="btn btn-primary">Tạo mới</a>
        <a href="{{ url("/backend/category/index") }}" class="btn btn-success">Refresh</a>
    </div>

    <form name="searchfilter" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" style="border: 1px solid grey; border-radius: 5px; padding: 10px;">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="keyword">Tìm kiếm</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search for..." value="{{ $search_keyword }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="orderby">Sắp xếp theo...</label>
                    <select name="orderby" id="orderby" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="id" {{ $order_by == "id" ? "selected" : "" }}>ID</option>
                        <option value="Category_Name" {{ $order_by == "Category_Name" ? "selected" : "" }}>Name</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="orderdir">Hướng sắp xếp...</label>
                    <select name="orderdir" id="orderdir" class="custom-select">
                        <option value="">Choose...</option>
                        <option value="ASC" {{ $order_dir == "ASC" ? "selected" : "" }}>Ascending</option>
                        <option value="DESC" {{ $order_dir == "DESC" ? "selected" : "" }}>Descending</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label for="">Filter</label>
                    <div><button class="btn" style="background: #5a5c69; color: white;"><i class="fas fa-search"></i></button></div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped table-sm">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Category_Name</th>
                <th>Slug</th>
                <th>Category_Parent</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($categories) && !empty($categories))
                @foreach($categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <td>
                        <?php $category->Category_Img = str_replace("public/", "", $category->Category_Img); ?>
                        <img alt=".img" src="{{ asset("storage/$category->Category_Img") }}" style="width: 52px; height: auto" />
                    </td>
                    <td>{{ $category->Category_Name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        @foreach($parentcategories as $pacategory)
                            @if($pacategory->t1_id == $category->id)
                                {{ $pacategory->t2_name }}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ url("/backend/category/info/$category->id") }}" class="btn btn-info" data-toggle="tooltip" title="Info"><i class="fas fa-info-circle"></i></a>
                        <a href="{{ url("/backend/category/edit/$category->id") }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                        <a href="{{ url("/backend/category/delete/$category->id") }}" class="btn btn-danger" data-toggle="tooltip" title="Delete"><i class="fas fa-minus-circle"></i></a>
                    </td>
                </tr>
                @endforeach
            @else
                Chưa có bản ghi nào trong bảng này
            @endif
        </tbody>
    </table>

    {{ $categories->links("pagination::bootstrap-4") }}

@endsection


@section('appendjs')
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
@endsection
