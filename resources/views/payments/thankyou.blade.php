@extends("layouts.main")

@section("meta_title",\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_THANKYOU))
@section("meta_description",\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_THANKYOU))
@section("meta_keywords",\App\Models\Seo::getMetaKeywords(\App\Models\MenuItem::PAGE_THANKYOU))
@section("canonical",\App\Models\Seo::getCanonical(\App\Models\MenuItem::PAGE_THANKYOU))

@section("content")
    <div class="checkout_page">
        <div class="container">
            <div class="checkout_page-wrap">
                <h1 class="checkout_page-title">{{ \App\Models\StaticTrans::t("thankyou_h1","Thank you!",\App\Models\MenuItem::PAGE_THANKYOU) }}</h1>
                <div class="checkout_page-box">
                    <div class="checkout_page-form">
                        <div class="checkout_page-thanks">
                            <p>{{ \App\Models\StaticTrans::t("thankyou_desc","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",\App\Models\MenuItem::PAGE_THANKYOU) }}</p>
                            <a href="{{route("profile")}}" class="btn main-btn-2 btn-fourthcolor">{{ \App\Models\StaticTrans::t("thankyou_to_profile","GO TO PROFILE",\App\Models\MenuItem::PAGE_THANKYOU) }}<i class="mainicon-edit"></i></a>
                        </div>
                    </div>
                    <div class="checkout_result checkout_page-result">
                        <div class="checkout_result__block">
                            <div class="checkout_result__block-img">
                                <img src="{{asset($course->image)}}" alt="{{$course->alt}}">
                            </div>
                            <div class="checkout_result__block-content">
                                <p class="checkout_result__block-title">{{$course->title}}</p>
                                <p class="checkout_result__block-price">${{$tariff->price??''}}</p>
                            </div>
                        </div>
                        <div class="checkout_result__info">
                            <div class="checkout_result__info-item">
                                <p class="checkout_result__info-name">Rate:</p>
                                <p class="checkout_result__info-data">{{$tariff->title??''}}</p>
                            </div>
                            <div class="checkout_result__info-item">
                                <p class="checkout_result__info-name">Total:</p>
                                <p class="checkout_result__info-data">${{$tariff->price??''}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
