<?php

namespace App\Rules;

use App\Models\User;
use App\UserProfile;
use Illuminate\Contracts\Validation\Rule;

class ActiveUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       $user = User::where(["email"=>$this->email])->first();

       if(!empty($user))
       {

       }
        if(!empty($profile) || !empty($profile2) || !empty($profile3)) {
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You are not allowed to login';
    }
}
