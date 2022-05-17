<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,'.auth()->user()->id,
            'phone' => 'required|phone:AUTO|unique:users,phone,'.auth()->user()->id,
            "avatar" =>'image|mimes:jpg,png,jpeg|max:2048',

            'current_password' => [ new MatchOldPassword],
            'password' => [
                'required_with:current_password',
              //  'min:12',
               // 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'

            ],
            'password_confirmation' => ['same:password'],
            'first_name' => 'required',
            'last_name' => 'required',
            // 'instagram' => 'required',

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone' => 'The :attribute field contains an invalid number.',
        ];
    }
}
