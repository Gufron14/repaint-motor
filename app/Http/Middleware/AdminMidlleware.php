<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMidlleware
{   

    public function handle(Request $request, Closure $next): Response
    {           
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return $next($request);
    }
}
