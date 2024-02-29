<?php

declare(strict_types=1);

namespace Stancl\Tenancy\Features;

use Carbon\Carbon;
use App\Models\User;
use Stancl\Tenancy\Tenancy;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Contracts\Tenant;
use Illuminate\Http\RedirectResponse;
use Stancl\Tenancy\Contracts\Feature;
use Stancl\Tenancy\Database\Models\ImpersonationToken;

class UserImpersonation implements Feature
{
    public static $ttl = 60; // seconds

    public function bootstrap(Tenancy $tenancy): void
    {
        $tenancy->macro('impersonate', function (Tenant $tenant, string $userId, string $redirectUrl, string $authGuard = null): ImpersonationToken {
            return ImpersonationToken::create([
                'tenant_id' => $tenant->getTenantKey(),
                'user_id' => $userId,
                'redirect_url' => $redirectUrl,
                'auth_guard' => $authGuard,
            ]);
        });
    }



    /**
     * Impersonate a user and get an HTTP redirect response.
     *
     * @param string|ImpersonationToken $token
     * @param int $ttl
     * @return RedirectResponse
     */
    public static function makeResponse($token, int $ttl = null): RedirectResponse
    {
        $token = $token instanceof ImpersonationToken ? $token : ImpersonationToken::findOrFail($token);

        if (((string) $token->tenant_id) !== ((string) tenant()->getTenantKey())) {
            abort(403);
        }
        

        $ttl = $ttl ?? static::$ttl;

        if ($token->created_at->diffInSeconds(Carbon::now()) > $ttl) {
            abort(403);
        }

        $user = User::where('global_id',$token->user_id)->first();
        $global = $user->global_id;
        
        if($token->user_id == $global) {
       $userlogin = new UserResource($user);
        // Auth::guard($token->auth_guard)->login($user);

        $token->delete();

        return redirect($token->redirect_url);
        }
    }
}


// $user = User::where('global_id',$token->user_id)->first();
//         $global = $user->global_id;
        
//         if($token->user_id == $global) {
//         //     auth()->loginUsingId($global);
//         Auth::guard($token->auth_guard)->login($user);
//         // $userlogin = new UserResource($user);
//         $token->delete();

//         return redirect($token->redirect_url);
//         }