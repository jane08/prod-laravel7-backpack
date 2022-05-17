@extends("layouts.main")

@section("meta_title",\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_AUTH))
@section("meta_description",\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_AUTH))
@section("meta_keywords",\App\Models\Seo::getMetaKeywords(\App\Models\MenuItem::PAGE_AUTH))
@section("canonical",\App\Models\Seo::getCanonical(\App\Models\MenuItem::PAGE_AUTH))


@section("og")
    <meta property="og:title" content="{{\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_AUTH)}}" />
    <meta property="og:description" content="{{\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_AUTH)}}" />

    <?php if(!empty(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_AUTH))){
    list($width, $height, $type, $attr) = getimagesize(asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_AUTH)));
    ?>
    <meta property="og:image" content="{{asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_AUTH))}}" />
    <meta property="og:image:width" content="{{$width}}" />
    <meta property="og:image:height" content="{{$height}}" />
    <?php } ?>
@endsection

@section("csrf")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection
@section("nav-div-class","navbar-area")


@section("content")
    <!-- header -->
    <header class="header-page">
        <div class="header-page-shape header-page-shape-middle">
            <img src="/assets/images/shape-8.svg" alt="shape">
        </div>
        <div class="container">
            <div class="header-page-content">
                <h1>{{ \App\Models\StaticTrans::t("auth_h1","Authentication",\App\Models\MenuItem::PAGE_AUTH) }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route("main")}}">{{ \App\Models\StaticTrans::t("auth_breadcrumb_home","Home",\App\Models\MenuItem::PAGE_AUTH) }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ \App\Models\StaticTrans::t("auth_authentication","Authentication",\App\Models\MenuItem::PAGE_AUTH) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- .end header -->
    <!-- authentication-section -->
    <div class="authentication-section pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 pb-30">
                    <div class="authentication-item">
                        <h3>{{ \App\Models\StaticTrans::t("auth_register","Register",\App\Models\MenuItem::PAGE_AUTH) }}</h3>
                        <div class="authentication-form">
                            <form method="POST" action="{{route("signup")}}">
                                @csrf
                                @if(!empty($errors->signup->all()))
                                    <div class="alert alert-danger">
                                @foreach ($errors->signup->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                    </div>
                                @endif
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="first_name" class="form-control"  placeholder="First Name*" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="last_name" class="form-control"  placeholder="Last Name*" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="email" class="form-control"  placeholder="Email*" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"  placeholder="Password*">
                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control"  placeholder="Confirm Password*">
                                    </div>
                                </div>
                                <p class="font-italic mb-20 form-desc">The password must be at least twelve characters long, contain upper and lower case letters, contain numbers, contain symbols like ! " ? $ % ^ & ).</p>

                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="tel" name="phone" class="form-control"  placeholder="Phone*" value="{{ old('phone') }}">
                                    </div>
                                </div>

                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <select name="country" class="form-control"  >
                                            <option value="">Select Country</option>
                                            <?php if(!empty($countries)){ ?>
                                            <?php foreach($countries as $id=>$country){ ?>
                                            <option value="{{$id}}">{{$country}}</option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="city" class="form-control"  placeholder="City" value="{{ old('city') }}">
                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="instagram" class="form-control"  placeholder="Instagram" value="{{ old('instagram') }}">
                                    </div>
                                </div>

                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="address" class="form-control"  placeholder="Address" value="{{ old('address') }}">
                                    </div>
                                </div>

                                <button type="submit" name="register" class="btn main-btn fourth-color full-width mb-20">REGISTER NOW</button>
                                <div class="authentication-account-access">
                                    <div class="authentication-account-access-item">
                                        <div class="input-checkbox">
                                            <input name="agree" type="checkbox" id="check2">
                                            <label for="check2">I agree to the <a href="{{url(\App\Models\MenuItem::PRIVACY_URL)}}">Privacy Policy</a> & <a href="{{url(\App\Models\MenuItem::TERMS_OF_SERVICE_URL)}}">Terms of Service</a></label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 pb-30">
                    <div class="authentication-item">
                        <h3>{{ \App\Models\StaticTrans::t("auth_login","Login",\App\Models\MenuItem::PAGE_AUTH) }}</h3>
                        <div class="authentication-form">
                            <form method="POST" action="{{route("login")}}">
                                @csrf
                                @if(!empty($errors->login->all()))
                                    <div class="alert alert-danger">
                                @foreach ($errors->login->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                    </div>
                                @endif
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="text" name="email" class="form-control"  placeholder="Username/Email Address*" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group mb-20">
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control"  placeholder="Password*">
                                    </div>
                                </div>
                                <div class="authentication-account-access mb-20">
                                    <div class="authentication-account-access-item">
                                        <div class="input-checkbox">
                                            <input name="remember_me" type="checkbox" id="check1">
                                            <label for="check1">Remember Me!</label>
                                        </div>
                                    </div>
                                    <div class="authentication-account-access-item">
                                        <div class="authentication-link">
                                            <a href="{{route("forgot-password-form")}}">Forgot password?</a>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="login" class="btn main-btn fourth-color full-width">LOG IN</button>

                            </form>

                            <a href="{{route("fb-redirect")}}" class="btn main-btn btn-border fourth-color full-width mt-20">LOG IN with Facebook</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .end authentication-section -->
@endsection
