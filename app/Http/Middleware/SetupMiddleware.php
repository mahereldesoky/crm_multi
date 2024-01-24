<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Setup\SetupController;
use App\Http\Controllers\Setup\AccountController;

class SetupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(env('APP_KEY') === null || empty(env('APP_KEY'))  && empty(config('app.key'))){
           Artisan::call('key:generate');
           Artisan::call('config:cache');
        }
        $setupStatus = setupStatus();
        if($request->is('setup/*')){
            if($setupStatus){
                return redirect('/');
            }
            return $next($request);
        }
        if(!$setupStatus){
            return redirect()->route('setup.index');
        }
        return $next($request);
    }
}
