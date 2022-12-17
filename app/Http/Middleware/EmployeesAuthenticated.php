<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeesAuthenticated
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
        if (Auth::check()) {
            // if user is not employee take him to his dashboard
            if (Auth::user()->isHR()) {
                return redirect(route('hr.dashboard'));
            } // allow employee to proceed with request
            else if (Auth::user()->isEmployee()) {
                return $next($request);
            }
        }

        abort(404);  // for other user throw 404 error
    }
}
