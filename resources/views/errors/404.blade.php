@extends("layouts.main")

@section("meta_title","Error 404")
@section("meta_description","Error 404")
@section("meta_keywords","Error 404")
@section("nav-div-class","navbar-area")


@section("content")
    <header class="header-page">
        <div class="header-page-shape header-page-shape-middle">
            <img src="{{asset("/assets/images/shape-7.svg")}}" alt="shape">
        </div>
        <div class="container">
            <div class="header-page-content">
                <h1>{{ \App\Models\StaticTrans::t("404_h1","404 Error Page",\App\Models\MenuItem::PAGE_404) }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('main',['lang'=>Illuminate\Support\Facades\App::getLocale()])}}}}">{{ \App\Models\StaticTrans::t("404_breadcrumb1","Home",\App\Models\MenuItem::PAGE_404) }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ \App\Models\StaticTrans::t("404_breadcrumb2","404 Error Page",\App\Models\MenuItem::PAGE_404) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- .end header -->
    <!-- error-page-section -->
    <section class="error-page-section p-tb-100">
        <div class="container">
            <div class="error-page-content">
                <div class="error-page-img">
                    <img src="{{ asset( \App\Models\StaticFile::t("404_404","/assets/images/404-3.png",\App\Models\MenuItem::PAGE_MAIN,\App\Models\StaticFile::TYPE_FILE,'404')) }}" alt="{{  \App\Models\StaticFile::t("404_404","/assets/images/404-3.png",\App\Models\MenuItem::PAGE_MAIN,\App\Models\StaticFile::TYPE_ALT,'404') }}">
                </div>
                <h2>{{ \App\Models\StaticTrans::t("404_title","Error 404: Page not found",\App\Models\MenuItem::PAGE_404) }}</h2>
                <p>{{ \App\Models\StaticTrans::t("404_desc","The page you were looking for could not be found.",\App\Models\MenuItem::PAGE_404) }}</p>
                <a href="{{route('main',['lang'=>Illuminate\Support\Facades\App::getLocale()])}}}}" class="btn main-btn-2 btn-fourthcolor">{{ \App\Models\StaticTrans::t("404_button","GO TO HOMEPAGE",\App\Models\MenuItem::PAGE_404) }} <i class="mainicon-edit"></i></a>
            </div>
        </div>
    </section>
    <!-- .end error-page-section -->
@endsection
