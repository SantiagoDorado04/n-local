<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            $request->session()->put('url.intended', $request->url());
            return redirect()->route('voyager.login');
        }

        return $next($request);
    }
}
