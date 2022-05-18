<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Profile;
use App\Models\StaticTrans;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function getAll()
    {
        return User::all();
    }

    public static function getOne($id)
    {
        return User::where(['id'=>$id])->get()->first();
    }

    public static function getOneByToken($token)
    {
        return User::where(['api_token'=>$token])->get()->first();
    }

    public static function getOneByEmail($email)
    {
        return User::where(['email'=>$email])->get()->first();
    }


    public static function getOneByPhone($phone)
    {
        return User::where(['phone'=>$phone])->get()->first();
    }

    public static function getUsersByRole($roleName = "student")
    {
        $users = [];
       $role = RoleService::getOne($roleName);
       if(!empty($role)) {
           $usersRoles = DB::table('model_has_roles')->where(["role_id" =>$role->id,"model_type"=>User::MODEL])->pluck("model_id");
          // $users = Profile::whereIn("id",$usersRoles)->get()->pluck('first_name', 'user_id')->toArray();
           $users = User::whereIn("id",$usersRoles)->get()->pluck('name', 'id')->toArray();
       }
        return $users;
    }

    public static function createUser($request)
    {
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
        }
        return $user;
    }

}
