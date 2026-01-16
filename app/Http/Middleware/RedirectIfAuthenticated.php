<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Authenticated users cannot access this resource.'
                    ], 403);
                }

                if (Auth::guard($guard)->name == "superadmin") {
                    return redirect("superadmin");
                }
                return redirect("superadmin");
            }
        }

        return $next($request);
    }
}
