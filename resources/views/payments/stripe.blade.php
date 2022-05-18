@extends("layouts.main")

@section("meta_title",\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_CHECKOUT))
@section("meta_description",\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_CHECKOUT))
@section("meta_keywords",\App\Models\Seo::getMetaKeywords(\App\Models\MenuItem::PAGE_CHECKOUT))
@section("canonical",\App\Models\Seo::getCanonical(\App\Models\MenuItem::PAGE_CHECKOUT))

@section("og")
    <meta property="og:title" content="{{\App\Models\Seo::getMetaTitle(\App\Models\MenuItem::PAGE_CHECKOUT)}}" />
    <meta property="og:description" content="{{\App\Models\Seo::getMetaDescription(\App\Models\MenuItem::PAGE_CHECKOUT)}}" />

    <?php if(!empty(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_CHECKOUT))){
    list($width, $height, $type, $attr) = getimagesize(asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_CHECKOUT)));
    ?>
    <meta property="og:image" content="{{asset(\App\Models\Seo::getOgImage(\App\Models\MenuItem::PAGE_CHECKOUT))}}" />
    <meta property="og:image:width" content="{{$width}}" />
    <meta property="og:image:height" content="{{$height}}" />
    <?php } ?>
@endsection

@section("csrf")
    <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section("styles")
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            width:100%;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
        .card-formss{
            width:100%;
        }
    </style>
@endsection

@section("content")
    <div class="checkout_page">
        <div class="container">
            <div class="checkout_page-wrap">
                <h1 class="checkout_page-title">Checkout</h1>
                <form method="POST" action="{{ route('purchase', ["product_id"=>$product->id]) }}" class="card-form card-formss" >
                    @csrf
                    @if(!empty($errors->all()))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                <div class="checkout_page-box">
                    <div class="checkout_page-form">
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="text" {{$disabled}} name="first_name" class="form-control"  placeholder="First Name*" value="{{ $dbUser->profile->first_name??old('first_name') }}">
                            </div>
                        </div>
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="text" {{$disabled}} name="last_name" class="form-control"  placeholder="Last Name*" value="{{ $dbUser->profile->last_name??old('last_name') }}">
                            </div>
                        </div>
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="text" {{$disabled}} name="email" class="form-control" placeholder="Your Email Address*" value="{{ $dbUser->email??old('email') }}">
                            </div>
                        </div>
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="tel" {{$disabled}} name="phone" class="form-control" placeholder="Your Phone Number*" value="{{ $dbUser->phone??old('phone') }}">
                            </div>
                        </div>
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="text" {{$disabled}} name="instagram" class="form-control"  placeholder="Instagram" value="{{ $dbUser->profile->instagram??old('instagram') }}" >
                            </div>
                        </div>
<?php if($type==\App\Models\Tariff::VIP){ ?>
                        <div class="form-group mb-20">
                            <div class="input-group">
                                <input type="text" {{$disabled}} name="address" class="form-control"  placeholder="Address" value="{{  $dbUser->profile->address??old('address') }}">
                            </div>
                        </div>
<?php } ?>


                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="message" class="form-control" rows="8" placeholder="Your Message"></textarea>
                            </div>
                        </div>

                        <br />
                        <div class="authentication-account-access">
                            <div class="authentication-account-access-item">
                                <div class="input-checkbox">
                                    <input name="agree" type="checkbox" id="check2">
                                    <label for="check2">I agree to data processing</label>
                                </div>
                            </div>
                        </div>

                        <div class="authentication-account-access">
                            <div class="authentication-account-access-item">
                                <div class="input-checkbox">
                                    <input name="subscribe" type="checkbox" id="check3" checked>
                                    <label for="check3">subscribe to newsletters</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="checkout_result checkout_page-result">
                        <div class="checkout_result__block">
                            <div class="checkout_result__block-img">
                                <img width="200" height="200" src="{{asset($product->image)}}" alt="{{$product->alt}}">
                            </div>
                            <div class="checkout_result__block-content">
                                <p class="checkout_result__block-title">{{$product->title}}</p>
                                <p class="checkout_result__block-price">${{$product->price??''}}</p>
                            </div>
                        </div>
                        <div class="checkout_result__info">

                            <div class="checkout_result__info-item">
                                <p class="checkout_result__info-name">Total:</p>
                                <p class="checkout_result__info-data">${{$product->price??''}}</p>
                            </div>
                        </div>

                        @if(session('message'))
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif
                        <input type="hidden" name="payment_method" class="payment-method">
                        <div class="col-lg-12 col-md-12">
                        <input class="StripeElement mb-3" name="card_holder_name" placeholder="Card holder name" >
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div id="card-element"></div>
                        </div>
                        <div id="card-errors" role="alert"></div>

<br />
                        <button class="checkout_result-btn pay">Pay</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section("scripts")
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe("{{ env('STRIPE_KEY') }}")
        let elements = stripe.elements()
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
        let card = elements.create('card', {hidePostalCode: true,style: style})
        card.mount('#card-element')
        let paymentMethod = null
        $('.card-form').on('submit', function (e) {
            $('button.pay').attr('disabled', true)
            if (paymentMethod) {
                return true
            }
            stripe.confirmCardSetup(
                "{{ $intent->client_secret }}",
                {
                    payment_method: {
                        card: card,
                        billing_details: {name: $('.card_holder_name').val()}
                    }
                }
            ).then(function (result) {
                if (result.error) {
                    $('#card-errors').text(result.error.message)
                    $('button.pay').removeAttr('disabled')
                } else {

                    paymentMethod = result.setupIntent.payment_method
                    $('.payment-method').val(paymentMethod)
                    $('.card-form').submit()
                }
            })
            return false
        })
    </script>
@endsection
