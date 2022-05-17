<?php

namespace App\Exceptions;

use App\Http\ApiResponse;
use Exception;
use Illuminate\Contracts\Validation\Validator;

class CustomValidationException extends Exception {
    protected $validator;

    protected $code = 422;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function render() {
        // return a json with desired format
        $cusromResponse = new ApiResponse();
      return $cusromResponse->response([], ['error_text' => $this->validator->errors()->first()],422);

       /* return response()->json([
            "code" => 422,
            "error" => "form validation error",
            "message" => $this->validator->errors()->first()
        ], $this->code);*/
    }
}
