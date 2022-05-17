<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ErrorHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\NewsResource;
use App\Http\Resources\PromoResource;
use App\Http\Resources\StaticTransResource;
use App\Http\Resources\StrikeEventResource;
use App\Http\Services\CategoryService;
use App\Http\Services\NewsService;
use App\Http\Services\PromoService;
use App\Http\Services\StaticTransService;
use App\Http\Services\StrikeEventService;
use App\Models\Article;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ErrorController extends Controller
{
    protected function error401(Request $request)
    {
        return view('vendor.backpack.base.errors.error401',['message'=>'You do not have enough rights to see this page']);
    }
}
