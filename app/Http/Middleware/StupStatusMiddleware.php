<?php

namespace App\Http\Middleware;

use App\Models\BusinessCategory;
use Closure;
use Illuminate\Http\Request;

class StupStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('business.setup.*')) {
            return $next($request);
        }

        if (auth('official')->check() && auth('official')->user()->business->setup_status == 0) {
            return redirect()->route('business.setup.step1');
        }
        return $next($request);

    }
}
