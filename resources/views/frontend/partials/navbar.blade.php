<div class="col-md-12" id="thenavbar">
    <nav class="navbar navbar-expand-sm navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav" id="navbar-ul">
                <li class="nav-item {{ Request::is('index') ? 'active' : '' }}"><a class="nav-link" href="{{ url("/index") }}">HOME</a></li>
                @foreach($nav_categories as $nav_category)
                <li class="nav-item {{ Request::is("category/$nav_category->id") ? 'active' : '' }} {{ Request::is("category/$nav_category->id/*") ? 'active' : '' }}"><a class="nav-link" href="{{ url("category/$nav_category->id/$nav_category->Category_Slug") }}">{{ $nav_category->Category_Name }}</a></li>
                @endforeach
                <li class="nav-item {{ Request::segment(1) === "find-us" ? 'active' : '' }}"><a class="nav-link" href="{{ url("/find-us") }}">FIND US</a></li> 
            </ul>
        </div>
    </nav>
</div>