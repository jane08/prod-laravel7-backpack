<?php

namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class SignupRequest extends FormRequest
{

    protected $errorBag = 'signup';
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'email' => 'required|email|unique:users',
             'password' => [
                 'required',
                 'confirmed',
                 'min:12',
                 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
             ],
             'phone' => 'required|unique:users|phone:AUTO',
             'agree' => 'required',
             'first_name' => 'required',
             'last_name' => 'required',

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
            'password.regex' => '
            The password must be at least twelve characters long, contain upper and lower case letters, contain numbers, contain symbols like ! " ? $ % ^ & )
            ',
        ];
    }

   /* protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }*/
}
