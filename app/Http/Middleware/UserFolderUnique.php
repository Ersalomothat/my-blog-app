<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserFolderUnique
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
            $folderName = 'my' . Auth::user()->id . 'folder';
            if (!Storage::disk('public')->exists($folderName)) {
                Storage::disk('public')->makeDirectory($folderName, 0755, true, true);
            }
            Config::set('elfinder.dir', ["storage/$folderName"]);
        }
        return $next($request);
    }
}
