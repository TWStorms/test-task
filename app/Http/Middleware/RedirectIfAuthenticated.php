<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

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

//        $blogger = \App\Models\User::where('email', $request->email)->first();
//        Auth::loginUsingId($blogger->id, true);
//        Auth::logout();

        if (Auth::check()) {
            $user = Auth::user();
            if (GeneralHelper::IS_ADMIN()){
                return redirect('/admin/dashboard');
            }
            if (GeneralHelper::IS_SUPERVISOR()){
                return redirect('/supervisor/dashboard');
            }
            if (GeneralHelper::IS_BLOGGER()){
                return redirect('/blogger/dashboard');
            }
        }

        return $next($request);
    }
}
