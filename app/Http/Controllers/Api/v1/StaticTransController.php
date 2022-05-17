<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ErrorHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\StaticTransResource;
use App\Http\Services\StaticTransService;
use App\Models\StaticTrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class StaticTransController extends Controller
{
    protected function index(Request $request)
    {
        return $this->apiResponse->response(StaticTransResource::collection(StaticTransService::getAll()));
    }

    protected function showPage(Request $request)
    {
        return $this->apiResponse->response(StaticTransResource::collection(StaticTransService::getListByPage($request->page_code)),ErrorHelper::getErrors($request));
    }
}
