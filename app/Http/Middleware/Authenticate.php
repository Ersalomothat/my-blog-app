<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\URL;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // return route('login');
            if ($request->routeIs('author.*')) {
                session()->flash('failed', 'You must sign in first');
                return redirect()->route('author/login', ['fail' => true, 'returnUrl' => URL::current()]);
            }
            // 3. goto RedirectIfAuthenticated
        }
        session()->flash('fail', 'You must login first!');
        return to_route('login');



        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
