<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->is_admin) {
            return redirect()->route('trips.index')->with('error', 'ليس لديك صلاحيات الوصول');
        }

        return $next($request);
    }
}