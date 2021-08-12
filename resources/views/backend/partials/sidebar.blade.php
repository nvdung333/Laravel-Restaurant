<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #0e5a2b; background-size: cover;" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url("/backend") }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url("/backend") }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>User Setting</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom:</h6>
                <a class="collapse-item" href="{{ url("/backend/user/index") }}">Users</a>
                <a class="collapse-item" href="{{ url("/backend/user/role") }}">Roles</a>
                <a class="collapse-item" href="{{ url("/backend/user/admin") }}">System Admin</a>
            </div>
        </div>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ url("/backend/category/index") }}">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Danh mục</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ url("/backend/product/index") }}">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Sản phẩm</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ url("/backend/restaurant/index") }}">
            <i class="fas fa-fw fa-store-alt"></i>
            <span>Nhà hàng</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Đơn hàng</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cog"></i>
            <span>Cấu hình</span></a>
    </li>

    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>