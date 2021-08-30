<?php

namespace App\Http\Middleware;

use App\Helpers\GeneralHelper;
use App\Helpers\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

//        $user = \App\Models\User::where('email', $request->email)->first();
//        Auth::loginUsingId($user->id, true);
//        Auth::logout();

        if (Auth::check()) {
dd(Auth::user());
            $user = Auth::user();
            if (GeneralHelper::IS_ADMIN()){
                return redirect('/home/');
            }
            if (GeneralHelper::IS_SUB_ADMIN()){
                return redirect('/home/');
            }
            if (GeneralHelper::IS_USER()){
                return redirect('/home/');
            }
        }

        return $next($request);
    }
}
