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

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Category_Name</th>
                <th>Category_Parent</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($categories) && !empty($categories))
                @foreach($categories as $category)
                <tr>
                    <th>{{ $category->id }}</th>
                    <td>img</td>
                    <td>{{ $category->Category_Name }}</td>
                    <td>
                        @foreach($parentcategories as $pacategory)
                            @if($pacategory->t1_id == $category->id)
                                {{ $pacategory->t2_name }}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ url("/backend/category/details/$category->id") }}" class="btn btn-info">Chi tiết</a>
                        <a href="{{ url("/backend/category/edit/$category->id") }}" class="btn btn-warning">Sửa</a>
                        <a href="{{ url("/backend/category/delete/$category->id") }}" class="btn btn-danger">Xóa</a>
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