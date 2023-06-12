<?php

namespace App\Http\Middleware\Permissions;

use App\Models\User;
use Closure;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class TrainerPermissions extends Middleware
{
    public function handle($request, Closure $next)
    {
        $user = auth('api')->user();
        if ($user->hasRole(User::ROLE_TRAINER)) {
            return $next($request);
        } else {
            return response('Unauthorized.', 401);
        }
    }
}
