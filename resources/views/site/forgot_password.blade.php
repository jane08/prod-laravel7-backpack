@extends("layouts.main")

@section("meta_title","Forgot Password")
@section("meta_description","Forgot Password")
@section("meta_keywords","Forgot Password")
@section("csrf")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection
@section("nav-div-class","navbar-area")


@section("content")
    <header class="header-page">
        <div class="header-page-shape header-page-shape-middle">
            <img src="{{asset("/assets/images/shape-7.svg")}}" alt="shape">
        </div>
        <div class="container">
            <div class="header-page-content">
                <h1>Forgot Password</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route("main")}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Forgot Password</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- .end header -->
    <!-- error-page-section -->
    <section class="error-page-section p-tb-100">
        <div class="container">
            <div class="col-12 col-md-6 pb-30">
            <div class="authentication-item">
                <h3>Reset Password</h3>
                <div class="authentication-form">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form method="POST" action="{{route("forgot-password")}}">
                        @csrf
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="text" name="email" class="form-control"  placeholder="Email Address*" value="{{ old('email') }}">
                            </div>
                        </div>
                        <button type="submit" name="reset" class="btn main-btn fourth-color full-width">Reset Password</button>
                    </form>
                </div>
            </div>
            </div>

        </div>
    </section>
    <!-- .end error-page-section -->
@endsection
