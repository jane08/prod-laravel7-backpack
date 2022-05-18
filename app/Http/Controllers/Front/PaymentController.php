<?php

namespace App\Http\Controllers\Front;

use App\Classes\Payments\Payment;
use App\Classes\Payments\Stripe;
use App\Helpers\CommonHelper;
use App\Helpers\EmailHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StripeRequest;
use App\Http\Resources\BenefitResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\ReviewResource;
use App\Http\Services\BenefitService;
use App\Http\Services\CourseCategoryService;
use App\Http\Services\CourseService;
use App\Http\Services\GalleryService;
use App\Http\Services\LangService;
use App\Http\Services\LessonService;
use App\Http\Services\LevelService;
use App\Http\Services\MailchimpService;
use App\Http\Services\MenuItemService;
use App\Http\Services\PartnerService;
use App\Http\Services\ProductService;
use App\Http\Services\ReviewService;
use App\Http\Services\TariffService;
use App\Http\Services\UserService;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Role;
use App\Models\Tariff;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class PaymentController extends Controller
{

    public function checkout(Request $request)
    {
        $clientSecret = "";
        $disabled = "";
        if (!empty($request->product_id)) {
            $product = ProductService::getOne($request->product_id);

            if(empty($product) )
            {
                return response()->view('errors.404', [], 404);
            }


            $dbUser = null;
            if (!empty(auth()->user()->id)) {
                $dbUser = UserService::getOne(auth()->user()->id);
                $intent = auth()->user()->createSetupIntent() ?? '';
                $clientSecret = $intent->client_secret;
                $disabled = "readonly";
            } else {

                $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));

                $intent = $stripe->setupIntents->create([
                    'payment_method_types' => ['card'],
                ]);

            }

            return view('payments.stripe', [
                "product" => $product,
                "intent" => $intent,
                "dbUser" => $dbUser,
                "disabled" => $disabled,
                "type" => $request->type ?? '',
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

    public function purchase(StripeRequest $request)
    {

        if($request["subscribe"]=="on")
        {
            try {
                MailchimpService::addMember($request['email'],MailchimpService::LISTID);

            } catch (\Exception $e) {

            }
        }
        $user = UserService::getOneByEmail($request['email']);
        if (empty($user)) {

            $user = UserService::getOneByPhone($request['phone']);
            if(!empty($user))
            {
                return redirect()->back()->withErrors([
                    "phone"=>"Phone number is already taken"
                ]);
            }

            $user = UserService::createUser($request);
            if (!empty($user)) {
                Role::saveUserRole($user, Role::ROLE_CLIENT);
                EmailHelper::sendEmail([], $request['email'], 'emails.set_password',"Set Password");
            }
        }

        $product = ProductService::getOne($request->product_id);

            try {

                $payment = new Payment(new Stripe);

                $payment->paying($user,$request);

                $transaction = Transaction::saveTransaction($user->id, Transaction::SUCCESS, $request,$product,  Transaction::STRIPE,Transaction::TYPE_PRODUCT);

            } catch (\Exception $exception) {
                return back()->with('error', $exception->getMessage());
            }

            return redirect(route("thank-you", ["product_id" => $product->id]));


    }

    public function thankyou(Request $request)
    {
        if (!empty($request->product_id)) {
            $product = ProductService::getOne($request->product_id);

            if (empty($product)) {
                return response()->view('errors.404', [], 404);
            }
            return view('payments.thankyou', [
                "product" => $product,
            ]);
        }
        return response()->view('errors.404', [], 404);
    }



}
