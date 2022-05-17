<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Services\RoleService;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{

    CONST DRIVER_TYPE = 'facebook';

    public function handleFacebookRedirect()
    {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver(static::DRIVER_TYPE)->user();

            $userExisted = User::where('oauth_id', $user->id)->where('oauth_type', static::DRIVER_TYPE)->first();

            if( $userExisted ) {

                Auth::login($userExisted);

                return redirect()->route('dashboard');

            }else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::DRIVER_TYPE,
                    'active' => CommonHelper::ONE,
                    'password' => Hash::make($user->id)
                ]);

                $profile = new Profile();
                $profile->first_name = $user->name;
                $profile->last_name = $user->name;
                $profile->user_id = $newUser->id;
                $profile->save();
                   /* $profile = Profile::forceCreate([
                        'first_name' => $user->name,
                        'last_name' => $user->name,
                        'country' =>  null,
                        'city' =>  null,
                        'instagram' => null,
                        // 'ip' => $request['ip'],
                        'user_id' => $newUser->id,
                    ]);*/

                    Role::saveUserRole($newUser, Role::ROLE_STUDENT);


                $activeUser = RoleService::checkActiveUser($newUser->email);
                if(!empty($activeUser)) {
                    Auth::login($newUser);

                    return redirect()->route('dashboard');
                }
                else{
                    return redirect(route("authentication"))->withErrors([
                        "email"=>"User is not active"
                    ]);
                }
            }


        } catch (Exception $e) {
            return redirect()->route('authentication');
        }

    }
}
