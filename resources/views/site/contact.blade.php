@extends("layouts.main")

@section("meta_title",\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_CONTACT))
@section("meta_description",\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_CONTACT))
@section("meta_keywords",\App\Models\Seo::getMetaKeywords(\App\Models\MenuItem::PAGE_CONTACT))
@section("canonical",\App\Models\Seo::getCanonical(\App\Models\MenuItem::PAGE_CONTACT))

@section("og")
    <meta property="og:title" content="{{\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_CONTACT)}}" />
    <meta property="og:description" content="{{\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_CONTACT)}}" />

    <?php if(!empty(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_CONTACT))){
    list($width, $height, $type, $attr) = getimagesize(asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_CONTACT)));
    ?>
    <meta property="og:image" content="{{asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_CONTACT))}}" />
    <meta property="og:image:width" content="{{$width}}" />
    <meta property="og:image:height" content="{{$height}}" />
    <?php } ?>
@endsection

@section("csrf")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection
@section("nav-div-class","navbar-area")


@section("content")
    <header class="header-page">
        <div class="container">
            <div class="header-page-content">
                <h1>Contact</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route("main")}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- .end header -->
    <!-- contact-information-section -->
    <section class="contact-information-section pt-50 pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-5 pb-30">
                    <div class="contact-information-item">
                        <div class="section-title section-title-shapeless section-title-left text-start">
                            <h2><span>{{ \App\Models\StaticTrans::t("contact_h2_part1","Hi! I`m Jexi",\App\Models\MenuItem::PAGE_CONTACT) }}</span> {{ \App\Models\StaticTrans::t("contact_h2_part2","You`re Welcome To Contact Me",\App\Models\MenuItem::PAGE_CONTACT) }}</h2>
                        </div>
                        <div class="contact-options">
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-phone-call"></i></div>
                                <div class="contact-option-details">
                                    <p>Mobile: <a href="tel:{{ \App\Models\StaticTrans::t("contact_phone1_city","001-800-388-80-90",\App\Models\MenuItem::PAGE_CONTACT) }}">{{ \App\Models\StaticTrans::t("contact_phone1","800 388 80 90",\App\Models\MenuItem::PAGE_CONTACT) }}</a></p>
                                    <p>Hotline: <a href="tel:{{ \App\Models\StaticTrans::t("contact_hotline_city","001-1800-1102",\App\Models\MenuItem::PAGE_CONTACT) }}">{{ \App\Models\StaticTrans::t("contact_hotline","1800 1102",\App\Models\MenuItem::PAGE_CONTACT) }}</a></p>
                                    <p>Email: <a href="mailto:{{ \App\Models\StaticTrans::t("contact_email","hello@jexi.com",\App\Models\MenuItem::PAGE_CONTACT) }}">{{ \App\Models\StaticTrans::t("contact_email","hello@jexi.com",\App\Models\MenuItem::PAGE_CONTACT) }}</a></p>
                                </div>
                            </div>
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-network"></i></div>
                                <div class="contact-option-details">
                                    <p>{{ \App\Models\StaticTrans::t("contact_address","The Queen's Walk, PO Box 567 Hostin st. 433, Los Angeles California, US.",\App\Models\MenuItem::PAGE_CONTACT) }}</p>
                                </div>
                            </div>
                            <div class="contact-option-item">
                                <div class="contact-option-icon"><i class="flaticon-clock"></i></div>
                                <div class="contact-option-details">
                                    <p>{{ \App\Models\StaticTrans::t("contact_days1","Monday - Friday:",\App\Models\MenuItem::PAGE_CONTACT) }} <span>{{ \App\Models\StaticTrans::t("contact_time1","09:00 am - 5:00 pm",\App\Models\MenuItem::PAGE_CONTACT) }}</span></p>
                                    <p>{{ \App\Models\StaticTrans::t("contact_days2","Sunday & Saturday:",\App\Models\MenuItem::PAGE_CONTACT) }} <span>{{ \App\Models\StaticTrans::t("contact_time2","10:30 am - 1:00 pm",\App\Models\MenuItem::PAGE_CONTACT) }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7 pb-30">
                    <div class="contact-information-item">
                        <div class="contact-information-image">
                            <img src="{{ asset( \App\Models\StaticFile::t("contact_image","assets/images/profile-image-1.png",\App\Models\MenuItem::PAGE_MAIN,\App\Models\StaticFile::TYPE_FILE,'contact')) }}" alt="{{\App\Models\StaticFile::t("contact_image","assets/images/profile-image-1.png",\App\Models\MenuItem::PAGE_MAIN,\App\Models\StaticFile::TYPE_ALT)}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- .end contact-information-section -->
    <section class="contact_feedback_form">
        <div class="container">
            <div class="contact_feedback_form-wrap">
                <h2 class="contact_feedback_form-title">{{ \App\Models\StaticTrans::t("contact_feedback_title","Feedback form",\App\Models\MenuItem::PAGE_CONTACT) }}</h2>
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <form class="contact_feedback_form-form" method="POST" action="{{route("send-feedback")}}">
                    @csrf
                    @if(!empty($errors->all()))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Your Name"  data-error="Please enter your name" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Your Email Address"  data-error="Please enter your email" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="Your Phone Number"  data-error="Please enter your phone number" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group mb-20">
                                <div class="input-group">
                                    <textarea name="message" class="form-control" id="message" rows="6" placeholder="Your Message"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 text-center">
                            <button class="contact_feedback_form-submit" type="submit">SEND A MESSAGE</button>
                            <div id="msgSubmit"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
