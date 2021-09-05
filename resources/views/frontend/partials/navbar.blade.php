<div class="col-md-12" id="thenavbar">
    <nav class="navbar navbar-expand-md navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" id="navbar-ul">
                <li class="nav-item {{ Request::is('index') ? 'active' : '' }}"><a class="nav-link" href="{{ url("/index") }}">HOME</a></li>
                @foreach($nav_categories as $nav_category)
                <li class="nav-item {{ Request::is("order/$nav_category->id") ? 'active' : '' }} {{ Request::is("order/$nav_category->id/*") ? 'active' : '' }}"><a class="nav-link" href="{{ url("order/$nav_category->id/$nav_category->Category_Slug") }}">{{ $nav_category->Category_Name }}</a></li>
                @endforeach
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown">
                        INFORMATION
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ Request::segment(1) === "find-us" ? 'active' : '' }}" href="{{ url("/find-us") }}">FIND US</a>
                        <a class="dropdown-item" href="#tracking">ORDER TRACKING</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline" method="get" action="{{ url("search") }}">
                <?php isset($search_keyword) ? $search_keyword : $search_keyword="" ?>
                <input name="keyword" class="form-control mr-sm-2" type="search" placeholder="Search..." aria-label="Search" value="{{$search_keyword}}">
                <button class="btn my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </nav>
</div>