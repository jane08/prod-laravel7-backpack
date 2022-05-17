<?php

namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class StripeRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'email' => 'required|email',
           //  'password' => 'required|confirmed|min:6',
             'phone' => 'required|phone:AUTO',
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
        ];
    }

   /* protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }*/
}
