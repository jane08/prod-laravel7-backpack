<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Http\Services\NotificationService;
use App\Http\Services\RoleService;
use App\Http\Services\ScoreService;
use App\Http\Services\UserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait; // <------------------------------- this one
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one

class User extends Authenticatable
{
    use Notifiable;
    use CrudTrait; // <----- this
    use HasRoles; // <------ and this
    use Billable;
   // use \Backpack\CRUD\app\Models\Traits\CrudTrait; // <--- Add this line

 const MODEL = "App\Models\User";

    public $referral_link = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','phone','active','oauth_id','oauth_type','crypto_address','qr', 'email', 'password','referer_id','code','device','email_confirmation'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function scopePublished($query)
    {
        return $query->where('active', CommonHelper::ACTIVE);
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'user_id');
    }
    public function lessons()
    {
        return $this->belongsToMany('App\Models\Lesson', 'lesson_user','user_id','lesson_id');
    }


   /* public  function getUsersByRole($roleName = "student")
    {
        $users = [];
        $role = RoleService::getOne($roleName);
        if(!empty($role)) {
            $usersRoles = DB::table('model_has_roles')->where(["role_id" =>$role->id,"model_type"=>User::MODEL])->pluck("model_id");
            // $users = Profile::whereIn("id",$usersRoles)->get()->pluck('first_name', 'user_id')->toArray();
            $users = User::whereIn("id",$usersRoles)->make();
        }
        return $users;
    }*/

    public static function getUsersIdsByRole($roleName = "client")
    {
        $users = [];
        $role = RoleService::getOne($roleName);
        if(!empty($role)) {
            $usersRoles = DB::table('model_has_roles')->where(["role_id" =>$role->id,"model_type"=>User::MODEL])->pluck("model_id");
       $users = $usersRoles;
        }
        return $users;
    }

}
