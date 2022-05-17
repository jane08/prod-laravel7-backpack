@extends("layouts.main")

@section("meta_title","Error 403")
@section("meta_description","Error 403")
@section("meta_keywords","Error 403")
@section("nav-div-class","navbar-area")


@section("content")
    <header class="header-page">
        <div class="header-page-shape header-page-shape-middle">
            <img src="{{asset("/assets/images/shape-7.svg")}}" alt="shape">
        </div>
        <div class="container">
            <div class="header-page-content">
                <h1>Forbidden</h1>

            </div>
        </div>
    </header>
    <!-- .end header -->
    <!-- error-page-section -->

    <!-- .end error-page-section -->
@endsection
