<?php

namespace App\Classes\Payments;

use App\Http\Services\UserService;
use App\Interfaces\PaymentInterface;
use Illuminate\Support\Str;

class Payment
{
   protected $payment;

   public function __construct(PaymentInterface $payment)
   {
        $this->payment = $payment;
   }

   public function paying($user,$request)
   {
       $this->payment->pay($user,$request);
   }

}
