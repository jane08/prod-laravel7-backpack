<?php

namespace App\Classes\Payments;

use App\Helpers\CommonHelper;
use App\Http\Services\ProductService;
use App\Http\Services\UserService;
use App\Interfaces\PaymentInterface;
use Illuminate\Support\Str;

class Stripe implements PaymentInterface
{
    public function pay($user,$request)
    {
        $product = ProductService::getOne($request->product_id);
        $paymentMethod = $request->input('payment_method');

        $price = $product->price??0;

        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $user->charge($price * CommonHelper::STRIPE_HUNDRED, $paymentMethod);

    }

}
