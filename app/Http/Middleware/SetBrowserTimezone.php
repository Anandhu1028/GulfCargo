<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetBrowserTimezone
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
        // Get the browser timezone from the request headers or use a default value
        $browserTimezone = $request->header('timezone', 'UTC');


        // Set the application's timezone based on the browser timezone
        config(['app.timezone' => $browserTimezone]);

        return $next($request);
    }
}
