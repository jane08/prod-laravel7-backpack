<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="@yield("meta_description")">
    <meta name="keywords" content="@yield("meta_keywords")">
    <meta name="author" content="HiBootstrap">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />

    @yield("csrf")

    <title> @yield("meta_title") </title>
    <link rel="icon" href="" type="image/png" sizes="16x16">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-reboot.min.css') }}" type="text/css" media="all" />
    <!-- animate css -->

    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css" media="all" />

    <link rel="canonical" href="@yield("canonical")" />

    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @yield('styles')

    @yield("og")

</head>

<body>
<!-- navbar -->
<div class="">
    <div class="navbar-area navbar-area-two">

        <!-- desktop menu -->
        <div class="main-nav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" href="{{url("/")}}">
                        <img src="{{ asset( \App\Models\StaticFile::t("main_logo","/uploads/main/logo-4.png",\App\Models\MenuItem::PAGE_MAIN)) }}" alt="{{ \App\Models\StaticTrans::t("main_alt_log","logo",\App\Models\MenuItem::PAGE_MAIN) }}" class="logo">
                    </a>

                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto">
                            <?php foreach(App\Http\Services\MenuItemService::getAll(App\Models\MenuItem::TOP ,App\Models\MenuItem::OLDEST) as $topMenu){

                                $menuLink = $topMenu->getLink();
                                ?>
                            <li class="nav-item">
                                <a href=" {{$menuLink}} " class="nav-link active">{{$topMenu->name}}</a>
                            </li>

                            <?php } ?>
                        </ul>
                    </div>
                    <div class="navbar-option">
                        <div class="navbar-option-item navbar-option-authentication">
                            <?php
                            $route = "authentication";
                            $buttonText =  \App\Models\StaticTrans::t("main_login_signup_button","LOGIN / SIGNUP",\App\Models\MenuItem::PAGE_MAIN) ;
                            if (Illuminate\Support\Facades\Auth::check()) {
                            $route = "dashboard";
                                $buttonText =  \App\Models\StaticTrans::t("main_my_cabinet","My Cabinet",\App\Models\MenuItem::PAGE_MAIN) ;
                            }
                            ?>
                            <a href="{{route("$route")}}" class="btn main-btn-2 btn-fourthcolor text-nowrap">{{ $buttonText }}</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- .end navbar -->
<!-- header -->

    @yield("content")
<!-- footer -->
<footer>
    <div class="footer-upper pt-60 pb-80 bg-purple">

        @yield("modals")

        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-3">
                    <div class="footer-content-item">
                        <div class="footer-logo">
                            <a href="{{route("main")}}"><img src="{{ asset( \App\Models\StaticFile::t("main_logo_footer","/uploads/main/logo-footer.png",\App\Models\MenuItem::PAGE_MAIN)) }}" alt="{{\App\Models\StaticFile::t("main_logo_footer","/uploads/main/logo-footer.png",\App\Models\MenuItem::PAGE_MAIN,\App\Models\StaticFile::TYPE_ALT)}}"></a>
                        </div>
                        <div class="footer-details footer-address-info">
                            <div class="footer-address-info-item footer-address-info-item-secondcolor">
                                <h4>{{ \App\Models\StaticTrans::t("main_call_us","Call Us",\App\Models\MenuItem::PAGE_MAIN) }}</h4>
                                <p class="footer-contact-number"><a href="tel:001-{{ \App\Models\StaticTrans::t("main_footer_phone1","800 388 80 90",\App\Models\MenuItem::PAGE_MAIN) }}">{{ \App\Models\StaticTrans::t("main_footer_phone1","800 388 80 90",\App\Models\MenuItem::PAGE_MAIN) }}</a><span>{{ \App\Models\StaticTrans::t("main_footer_or","or",\App\Models\MenuItem::PAGE_MAIN) }}</span><a href="tel:001-{{ \App\Models\StaticTrans::t("main_footer_phone2","667 234 32 67",\App\Models\MenuItem::PAGE_MAIN) }} ">{{ \App\Models\StaticTrans::t("main_footer_phone2","667 234 32 67",\App\Models\MenuItem::PAGE_MAIN) }}</a></p>
                            </div>
                            <div class="footer-address-info-item footer-address-info-item-secondcolor">
                                <p class="footer-email"><a href="mailto:{{ \App\Models\StaticTrans::t("main_email","hello@jexi.com",\App\Models\MenuItem::PAGE_MAIN) }}">{{ \App\Models\StaticTrans::t("main_email","hello@jexi.com",\App\Models\MenuItem::PAGE_MAIN) }}</a></p>
                            </div>
                            <div class="footer-address-info-item footer-address-info-item-secondcolor">
                                <p class="footer-availability"><span>{{ \App\Models\StaticTrans::t("main_footer_time","9 AM – 5 PM DC",\App\Models\MenuItem::PAGE_MAIN) }}</span>, {{ \App\Models\StaticTrans::t("main_footer_days","Monday – Friday",\App\Models\MenuItem::PAGE_MAIN) }}</p>
                            </div>
                            <div class="footer-address-info-item footer-address-info-item-secondcolor">
                                <p class="footer-physical-address">{{ \App\Models\StaticTrans::t("main_address","PO Box 567 Hostin st. 433, Los Angeles California, US.",\App\Models\MenuItem::PAGE_MAIN) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="footer-lower bg-off-white">
        <div class="container">
            <div class="footer-lower-grid">
                <div class="footer-lower-item footer-lower-info">
                    <div class="footer-copyright-text footer-copyright-text-secondcolor">
                        <p><span> {{ \App\Models\StaticTrans::t("copyright","© 2022 laravel7 backpack",\App\Models\MenuItem::PAGE_MAIN)  }} </span> Design & Developed By <a href="#" target="_blank">Jane</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- .end footer -->

<!-- scroll-top -->
<div class="scroll-top scroll-top-secondcolor" id="scrolltop">
    <div class="scroll-top-inner">
        <span><i class="flaticon-up-arrow"></i></span>
    </div>
</div>
<!-- .end scroll-top -->

<!-- essential js -->

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
@yield("scripts")
<script src="{{ asset('assets/js/app.js') }}"></script>

</body>
</html>
