<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CommonHelper;
use App\Helpers\EmailHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\BenefitResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\PasswordResetResource;
use App\Http\Resources\ReviewResource;
use App\Http\Services\_CountryService;
use App\Http\Services\BenefitService;
use App\Http\Services\CourseService;
use App\Http\Services\GalleryService;
use App\Http\Services\MenuItemService;
use App\Http\Services\NewsService;
use App\Http\Services\PartnerService;
use App\Http\Services\ReviewService;
use App\Http\Services\RoleService;
use App\Http\Services\UserService;
use App\Models\Article;
use App\Models\Benefit;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\ModelHasRole;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PasswordReset;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SiteController extends Controller
{

    public function index()
    {
        $benefits = BenefitService::getAll(Benefit::OLDEST);

      /*  $article = NewsService::getOne(1);
        $categories = $article->categories;
        foreach($categories as $category){
            echo $category->name;
            die;
        }*/


        return view('site.index',[
            'benefits'=>$benefits
        ]);
    }

    public function benefits()
    {
        $benefits = BenefitService::getAll(Benefit::OLDEST);

        return view('site.benefits',[
            'benefits'=>$benefits
        ]);
    }

    public function page(Request $request,$lang,$slug)
    {

        $page = Page::findBySlug($slug);

        if (!$page)
        {
            return response()->view('errors.404', [], 404);
        }

        return view('site.page',[
            "page" => $page,

        ]);
    }

    public function authentication()
    {
        if(Auth::check()){
            return redirect(route("main"));
        }
        $countries = _CountryService::getAllArray();

        return view('site.authentication',[
            "countries" => $countries,

        ]);
    }

    public function signup(SignupRequest $request)
    {

        if(Auth::check()){
            return redirect(route("main"));
        }

        $user = User::forceCreate([
            'name' => $request['first_name']." ".$request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'api_token' => null,
            'phone' => $request['phone']??'',
            'active' => CommonHelper::ONE,
        ]);
        if(!empty($user)) {
            $profile = Profile::forceCreate([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'country' => $request['country'] ?? '',
                'city' => $request['city'] ?? '',
                'instagram' => $request['instagram'] ?? '',
                'address' => $request['address'] ?? '',
               // 'ip' => $request['ip'],
                'user_id' => $user->id,
            ]);

            Role::saveUserRole($user,Role::ROLE_STUDENT);

            EmailHelper::sendEmail([], $request['email'], 'emails.register',"Registration");

           $loginFields = $request->only(["email","password"]);
           if(Auth::attempt($loginFields)){
               return redirect(route("dashboard"));
           }
        }
    }

    public function login(LoginRequest $request)
    {

        if (Auth::check()) {
            return redirect(route("main"));
        }
        $rememberMe = false;
        $loginFields = $request->only(["email","password"]);


        if(($request['remember_me']=="on"))
        {
            $rememberMe = CommonHelper::ONE;
        }

        $activeUser = RoleService::checkActiveUser($request['email']);
        if(empty($activeUser))
        {

            return redirect(route("authentication"))->withErrors([
                "email"=>"User is not active"
            ],'login');
        }

        if(Auth::attempt($loginFields,$rememberMe)){
            return redirect(route("dashboard"));
        }
        return redirect(route("authentication"))->withErrors([
            "email"=>"Could not login"
        ],'login');

    }

    public function logout()
    {
        Auth::logout();
        return redirect(route("main"));
    }


    /* Reset password*/
    public function forgotPasswordForm()
    {
        return view('site.forgot_password',[
        ]);
    }
    public function forgotPassword(ForgotPasswordRequest $request)
    {

            $user = UserService::getOneByEmail($request->email);
            if (!empty($user)) {

                $password_reset = PasswordReset::where(['email' => $request->email])->get()->first();
                if (empty($password_reset)) {

                    DB::table('password_resets')->insert([
                        'email' => $request->email,
                        'token' => Str::random(60),
                        'created_at' => Carbon::now()
                    ]);

                    //Get the token just created above
                    $tokenData = DB::table('password_resets')
                        ->where('email', $request->email)->first();

                    if ($this->sendResetEmail($request->email, $tokenData->token)) {
                        return redirect()->back()->with('message', 'Check your email');
                    } else {
                        return redirect(route("forgot-password-form"))->withErrors([
                            "email"=>"Something went wrong"
                        ]);
                    }
                } else {
                    return redirect(route("forgot-password-form"))->withErrors([
                        "email"=>"Email was already sent"
                    ]);
                }
            }


    }

    public function recovery(Request $request, $token="")
    {
        if(empty($token) || empty($request->email))
        {
            return response()->view('errors.404', [], 404);
        }
       // $tokenData = PasswordReset::where(['email' => $request->email,'token'=>$request->token])->first();

            return view('site.recovery', [
                "token" => $token
            ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $tokenData = PasswordReset::where(['email' => $request->email,'token'=>$request->token])->first();
        if(!empty($tokenData))
        {

            $user = UserService::getOneByEmail($request->email);
            if(!empty($user)){
            $user->password =  Hash::make($request['password']);

            $user->save();

                PasswordReset::where(['email'=> $request->email])->delete();
                return redirect()->back()->with('message', 'Your password is changed successfully');
            }
            return redirect(route("recovery"))->withErrors([
                "email"=>"Something went wrong"
            ]);
        }
        return redirect(route("recovery"))->withErrors([
            "email"=>"Wrong token"
        ]);
    }


    public function contact()
    {

        return view('site.contact',[

        ]);
    }

    public function sendFeedback(FeedbackRequest $request)
    {

        $contact = new Contact();
        $contact->email = $request["email"];
        $contact->phone = $request["phone"];
        $contact->name = $request["name"];
        $contact->message = $request["message"];
        if($contact->save())
        {

          /*  $data = [
                'name' => $request["name"],
                'phone' =>  $request["phone"],
                'email' => $request["email"],
                'message' => $request["message"]
            ];*/
            $data = [
              "request"=>  $request
            ];

            EmailHelper::sendEmail($data, CommonHelper::ADMIN_EMAIL, 'emails.contact',"Feedback");
            return redirect()->back()->with('message', 'Your message was sent successfully');
        }

        return redirect(route("contact"))->withErrors([
            "email"=>"Something went wrong"
        ]);
    }



    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = env('APP_URL_FRONT') . '/recovery/' . $token . '?email=' . urlencode($user->email);
        $data = [
            'link' => $link
        ];
        try {
            EmailHelper::sendEmail($data, $email, 'emails.mail');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
/* End reset password */

}
