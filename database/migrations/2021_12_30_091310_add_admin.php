<?php

use Backpack\PermissionManager\app\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $user = \App\Models\User::where('email','admin@gmail.com')->first();
        if(empty($user)) {
            $user = new \App\Models\User();
            $user->name = "admin";
            $user->email = "admin@gmail.com";
            $user->password = '$2y$10$NZiFkLCxtODF.uLqogD8v.au2IVLctpKcdOFEbOVf.wBD1yi1nzqK';
            $user->save();
        }

        $role = Role::where('name','admin')->first();
        if(empty($role)) {
            $role = new Role();
            $role->name = "admin";
            $role->guard_name = "backpack";
            $role->save();
        }

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => "App\Models\User",
            'model_id' => $user->id,
        ]);

        $role = Role::where('name','client')->first();
        if(empty($role)) {
            $role = new Role();
            $role->name = "client";
            $role->guard_name = "backpack";
            $role->save();
        }
       /* $role = Role::where('name','teacher')->first();
        if(empty($role)) {
            $role = new Role();
            $role->name = "teacher";
            $role->guard_name = "backpack";
            $role->save();
        }*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        return null;
    }
}
