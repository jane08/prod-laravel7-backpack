<?php

namespace App\Http\Middleware;

use App\Http\Services\RightService;
use App\Http\Services\UserService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;

class customAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if(!backpack_user()->hasRole(RightService::ADMIN))
        {
            return redirect()->route('error401');
        }
        return $next($request);
    }
}
