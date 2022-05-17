<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use JWTAuth;

class JsonWebTokenAuthenticate
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
        $cookie = $request->cookie('user_token');
        // Проверить совпадает ли токен с тем, что хранится в базе
        $user = 1;
        $request->attributes->add(['user' => $user]);
        print_r($request);
        die;
        App::setLocale($request->lang??'ru_RU');
        return $next($request);
    }
}
