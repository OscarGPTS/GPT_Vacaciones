<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImpersonateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Never impersonate on admin routes — admin always acts as themselves
        if ($request->is('admin/*') || $request->is('admin')) {
            return $next($request);
        }

        if (session()->has('impersonate_user_id') && auth()->check()) {
            $originalUserId = session('impersonate_original_id');
            $originalUser = User::find($originalUserId);

            if ($originalUser && $originalUser->hasRole('super-admin')) {
                Auth::onceUsingId(session('impersonate_user_id'));
            } else {
                // Original user is no longer a super-admin — stop impersonating
                session()->forget(['impersonate_user_id', 'impersonate_original_id']);
            }
        }

        return $next($request);
    }
}
