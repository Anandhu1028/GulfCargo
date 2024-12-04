<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BranchMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()) {
            $user = $request->user();
            if ($user->superadmin == 1) {
                return redirect()->route('super-admin.dashboard');
            } elseif ($user->superadmin == 2) {
                return redirect()->route('agency-admin.dashboard');
            } elseif ($user->staff == null) {
                auth()->logout();
                toastr("User not found",type:"error");
                return redirect()->route('login');
            } elseif ($user->staff->branch == null) {
                auth()->logout();
                toastr("User branch not found",type:"error");
                return redirect()->route('login');
            }

            return $next($request);
        }
        return redirect()->route('login');
    }
}
