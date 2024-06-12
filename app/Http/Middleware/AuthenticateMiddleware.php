<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is not authenticated
        if (!Auth::check()) {
            // Redirect the user to the login page or return an unauthorized response
            Alert::warning('Unauthorized', 'You must be logged in to access that page');
            $data = ['openSignInModal' => true];
            return redirect()->back()->with($data);
        }

        // User is authenticated, allow them to proceed to the requested route
        return $next($request);
    }
}
