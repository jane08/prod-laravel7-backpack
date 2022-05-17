<?php

namespace App\Http\Controllers\Front;

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
        if (!empty($request->course_id) && $request->tariff_id) {
            $course = CourseService::getOne($request->course_id);
            $tariff = TariffService::getOne($request->tariff_id);

            if(empty($course) || empty($tariff))
            {
                return response()->view('errors.404', [], 404);
            }

           $courseHasTariff = Tariff::courseHasTariff($course->id,$tariff->id,$request->type??'');

            if(empty($courseHasTariff))
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
                "course" => $course,
                "tariff" => $tariff,
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
        $courseHasTariff = Tariff::courseHasTariff($request->course_id??'',$request->tariff_id??'',$request->type??'');

        if(empty($courseHasTariff))
        {
            return response()->view('errors.404', [], 404);
        }
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

            $user = User::forceCreate([
                'name' => $request['first_name'] . " " . $request['last_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['email']),
                'api_token' => null,
                'phone' => $request['phone'] ?? '',
                'active' => CommonHelper::ONE,
            ]);
            if (!empty($user)) {
                $profile = Profile::forceCreate([
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'instagram' => $request['instagram'] ?? '',
                    'address' => $request['address'] ?? '',
                    // 'ip' => $request['ip'],
                    'user_id' => $user->id,
                ]);

                Role::saveUserRole($user, Role::ROLE_STUDENT);



                EmailHelper::sendEmail([], $request['email'], 'emails.set_password',"Set Password");
            }
        }
        /*else {
            $user = $request->user();
        }*/

        $paymentMethod = $request->input('payment_method');
        $course = CourseService::getOne($request->course_id);
        $tariff = TariffService::getOne($request->tariff_id);
        $type = $request->type;

        $canBuy = Transaction::canBuy($user->id,$course->id,$type);
        if(!empty($canBuy['status'])) {
            try {
                $user->createOrGetStripeCustomer();
                $user->updateDefaultPaymentMethod($paymentMethod);
                $user->charge($tariff->price * CommonHelper::STRIPE_HUNDRED, $paymentMethod);

                $transaction = Transaction::saveTransaction($user->id, $course->id, $type, Transaction::SUCCESS, $request->tariff_id, Transaction::TYPE_COURSE, Transaction::STRIPE,$request['message']??'');

            } catch (\Exception $exception) {
                return back()->with('error', $exception->getMessage());
            }

            return redirect(route("thank-you", ["course_id" => $course->id, "tariff_id" => $tariff->id]));
        }
        else{
             return redirect(route("change-tariff", ["course_id" => $course->id, "tariff_id" => $tariff->id,"code"=>$canBuy['code']]));
        }

    }

    public function thankyou(Request $request)
    {
        if (!empty($request->course_id) && $request->tariff_id) {
            $course = CourseService::getOne($request->course_id);
            $tariff = TariffService::getOne($request->tariff_id);

            if (empty($course) || empty($tariff)) {
                return response()->view('errors.404', [], 404);
            }
            return view('payments.thankyou', [
                "course" => $course,
                "tariff" => $tariff,
                "type" => $request->type ?? '',
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

    public function changeTariff(Request $request)
    {
        $message = "";
        if (!empty($request->course_id) && $request->tariff_id) {
            $course = CourseService::getOne($request->course_id);
            $tariff = TariffService::getOne($request->tariff_id);

            if (empty($course) || empty($tariff)) {
                return response()->view('errors.404', [], 404);
            }

            if($request->code == Transaction::CODE_CANT_EXTEND)
            {
                $message = "To extend you need to buy course first";
            }
            else if($request->code == Transaction::CODE_CANT_BUY){
                $message = "You already have this course. You may extend this course if you like";
            }

            return view('payments.change_tariff', [
                "course" => $course,
                "tariff" => $tariff,
                "message" => $message,
                "type" => $request->type ?? '',
                "code" => $request->code ?? '',
            ]);
        }
        return response()->view('errors.404', [], 404);
    }

}
