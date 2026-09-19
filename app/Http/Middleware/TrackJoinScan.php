<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackJoinScan
{
    public function handle(Request $request, Closure $next): Response
    {
        // Session flash so signup can attribute even if user does not register immediately
        if ($request->route('code')) {
            session(['join_code' => $request->route('code')]);
        }

        return $next($request);
    }
}
