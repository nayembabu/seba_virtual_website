<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AdminAuthorizeMiddleware
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
        $user = Auth::guard('admin')->user();
        $list = collect(config('role'))->pluck(['access'])->flatten();
        $filtered = $list->intersect($user->admin_access);
        
        if ($user->is_admin == 0) {
            return redirect()->intended(route('mod.index'));
        }
        
        if ($user->is_admin == 2) {
            return redirect()->intended(route('manager.dashboard'));
        }

        if (!in_array($request->route()->getName(), $list->toArray()) || in_array($request->route()->getName(), $filtered->toArray())) {
            return $next($request);
        }
        
        return redirect()->route('admin.403');
    }
}
