<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated using the 'admin' guard
        if (!Auth::guard('admin')->check()) {
            // Redirect unauthenticated users to the admin login page
            return redirect()->route('admin.login')
                ->with('error', 'Please log in as an admin to access this page.');
        }

        return $next($request);
    }
}
