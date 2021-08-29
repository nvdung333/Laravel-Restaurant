@extends('frontend.layouts.main')
@section('title', 'Homepage')

@section('content')
    <div class="row no-gutters">
        <div id="home-content">
            <div id="home-content-img-center">
                <img class="img-fluid" src="{{ asset("/storage/images_setting/banner-center.jpg") }}" alt="center-img">
            </div>
            <div class="row no-gutters" id="home-content-img-side">
                <div class="col-6" id="home-content-img-left">
                    <img class="img-fluid" src="{{ asset("/storage/images_setting/banner-left.jpg") }}" alt="left-img">
                </div>
                <div class="col-6" id="home-content-img-right">
                    <img class="img-fluid" src="{{ asset("/storage/images_setting/banner-right.jpg") }}" alt="right-img">
                </div>
            </div>
            <div id="home-content-link">
                <a href="#order" class="btn" role="button">
                    <i class="fab fa-elementor"></i>
                    <span id="home-content-link-title">ORDER</span>
                </a>
            </div>
        </div>
    </div>
@endsection
