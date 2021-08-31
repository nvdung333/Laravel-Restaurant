<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VINAKOOK - @yield("title")</title>

    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset("/fe-assets/site/vendor/fontawesome-free-5.15.3-web/css/all.css") }}">

    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/fe-assets/site/vendor/bootstrap-4.6.0/css/bootstrap.css") }}">
    
    <!-- bootstrap jquery -->
    <script src="{{ asset("/fe-assets/site/vendor/jquery/jquery-3.6.0.slim.min.js") }}"></script>
    <script src="{{ asset("/fe-assets/site/vendor/jquery/jquery-3.6.0.min.js") }}"></script>

    <!-- bootstrap javascript 1 -->
    <script src="{{ asset("/fe-assets/site/vendor/bootstrap-4.6.0/js/bootstrap.bundle.min.js") }}"></script>

    <!-- bootstrap popper -->
    <script src="{{ asset("/fe-assets/site/vendor/popper.min.js") }}"></script>

    <!-- bootstrap javascript 2 -->
    <script src="{{ asset("/fe-assets/site/vendor/bootstrap-4.6.0/js/bootstrap.min.js") }}"></script>

    
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset("/fe-assets/site/site-css.css") }}">
</head>
<body>
    <!-- section-header&navbar -->
    <section class="row no-gutters" id="ontopsticky">
        @include('frontend.partials.header')
        @include('frontend.partials.navbar')
    </section>
    <!-- end section-header&navbar -->


    <!-- section-content -->
    <section class="content" id="content">
        @yield('content')
    </section>
    <!-- end section-content -->


    <!-- section-footer -->
    @include('frontend.partials.footer')
    <!-- end section-footer -->


    <!-- cart button -->
    @yield('cart-btn')
    <!-- end cart button -->

    <!-- Custom JS for this template-->
    <script src="{{ asset("/fe-assets/site/site-js.js") }}"></script>

    @yield('appendjs')

</body>
</html>


