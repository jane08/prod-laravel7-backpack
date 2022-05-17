<?php

namespace App\Http\Middleware;

use App\Models\MenuItem;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class CheckPage
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

        if (!array_key_exists($request->page_code, MenuItem::$pages)) {
            $request->attributes->add(['error' => '404']);
            $request->attributes->add(['error_text' => 'Страница не найдена']);
        }

            return $next($request);

    }
}
