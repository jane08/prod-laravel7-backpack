<?php

namespace App\Http;

use App\Helpers\ImageHelper;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public $status;
    public $data;
    public $errors = [];

    public function success($data,$status=200)
    {
        $this->data = $data;
        $this->status = $status;
        return (array)$this;
    }

    public function error($data,$errors,$status=405)
    {
        $this->data = $data;
        $this->status = $status;
        $this->errors = $errors;
        return (array)$this;
    }

    public function response($data,$errors=null,$status=200)
    {
        $code = 200;
        if($errors)
        {
            if($status==422)
            {
                $code = 422;
            }
            else{
                $code = 405;
            }
        }

        $this->data = $errors?[]:$data;
        $this->status = $code;
        $this->errors = $errors;
        return (array)$this;
    }

}
