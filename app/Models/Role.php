<?php

namespace App\Models;

use App\Http\Services\RoleService;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModelHasRole;

class Role extends Model
{

    const ROLE_STUDENT = "student";
    const ROLE_CLIENT = "client";
    const ROLE_ADMIN = "admin";
    const MODEL_TYPE = "App\Models\User";

    protected $table = 'roles';


    public static function saveUserRole($user,$role)
    {
        $role = RoleService::getOne($role);
        if(!empty($role)) {
            $modelHasRole = ModelHasRole::where(["model_id" => $user->id,'model_type'=>Role::MODEL_TYPE, "role_id"=>$role->id])->first();
            if(empty($modelHasRole))
            {
                $modelHasRole = new ModelHasRole();
                $modelHasRole->role_id = $role->id;
                $modelHasRole->model_type = Role::MODEL_TYPE;
                $modelHasRole->model_id = $user->id;
                $modelHasRole->save();
            }
        }
    }

}
