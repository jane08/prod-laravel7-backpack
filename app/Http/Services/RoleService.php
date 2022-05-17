<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\StaticTrans;
use App\Models\User;
use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public static function getAll()
    {
        return DB::table('roles')->get();
    }

    public static function getOne($name)
    {
        return  DB::table('roles')->where('name', $name)->first();
    }

    public static function checkActiveUser($email)
    {
        $active = CommonHelper::ZERO;
        $user = User::where(["email"=>$email])->first();
        if(!empty($user))
        {
            $active = $user->active;
        }
        return $active;
    }

}
