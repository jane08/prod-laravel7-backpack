@extends("layouts.main")

@section("meta_title",$page->extras['meta_title']??'')
@section("meta_description",$page->extras['meta_description']??'')
@section("meta_keywords",$page->extras['meta_keywords']??'')
@section("canonical",$page->extras['canonical']??'')
@section("nav-div-class","navbar-area")


@section("content")
    <header class="header-page">
        <div class="header-page-shape header-page-shape-middle">
            <img src="{{asset("/assets/images/shape-7.svg")}}" alt="shape">
        </div>
        <div class="container">
            <div class="header-page-content">
                <h1>{{ $page->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('main',['lang'=>Illuminate\Support\Facades\App::getLocale()])}}">{{ \App\Models\StaticTrans::t("404_breadcrumb1","Home",\App\Models\MenuItem::PAGE_404) }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
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
                {!! $page->content  !!}
            </div>
        </div>
    </section>
    <!-- .end error-page-section -->
@endsection
