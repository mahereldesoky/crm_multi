<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeadrController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CompaignController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Admin\SubDomianController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
Route::middleware([
    'web','api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
Route::group(['prefix' => config('sanctum.prefix', 'sanctum')], static function () {
    Route::get('/csrf-cookie', [CsrfCookieController::class, 'show'])->middleware(['api',InitializeTenancyByDomain::class])->name('sanctum.csrf-cookie');

});


Route::get('/impersonate/{token}',[UserController::class,'test']);


Route::middleware(['api'])->prefix('api')->group(function () {
    Route::get('domains', [SubDomianController::class, 'apiData']);

    Route::get('/test/{token}',[UserController::class,'test']);

    Route::post('login',[UserController::class,'login']);

    Route::post('register',[UserController::class,'register']);

    Route::middleware('auth:sanctum')->group(function () {

    // Route::apiResource('/calender', 'CalenderController');
    Route::get('/calender', [CalenderController::class, 'index']);
        
    //Customer routes

    Route::DELETE('customers/{id}', [CustomerController::class, 'delete']);
    Route::get('customers', [CustomerController::class, 'index']);
    Route::get('customers/{id}', [CustomerController::class, 'show']);
    Route::post('customers', [CustomerController::class, 'store']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::post('/import',[CustomerController::class,'import']); 
    Route::get('/export-customer',[CustomerController::class,'exportCustomers']);


    // Roles Routes

    Route::resource('roles', RoleController::class);
    // Route::get('roles', RoleController::class ,'index');
    Route::post('/permission',[RoleController::class, 'createPermissions']);

    Route::post('logout',[UserController::class,'logout']);

    //user Routes
    Route::get('user/',[UserController::class,'user']);
    Route::get('user/{id}',[UserController::class,'show']);
    Route::put('user/{id}',[UserController::class,'update']);
    Route::get('users',[UserController::class,'index']);
    Route::delete('users/{id}',[UserController::class,'destroy']);
    Route::post('user',[UserController::class,'store']);

    //Leads routes

    Route::DELETE('leads/{id}', [LeadrController::class, 'delete']);
    Route::get('leads', [LeadrController::class, 'index']);
    Route::get('leads/{id}', [LeadrController::class, 'show']);
    Route::post('leads', [LeadrController::class, 'store']);
    Route::put('leads/{id}', [LeadrController::class, 'update']);




    //Team routes

    Route::DELETE('teams/{id}', [TeamController::class, 'delete']);
    Route::get('teams', [TeamController::class, 'index']);
    Route::get('teams/{id}', [TeamController::class, 'show']);
    Route::post('teams', [TeamController::class, 'store']);
    Route::put('teams/{id}', [TeamController::class, 'update']);


    //department routes

    Route::DELETE('departments/{id}', [DepartmentController::class, 'delete']);
    Route::get('departments', [DepartmentController::class, 'index']);
    Route::get('departments/{id}', [DepartmentController::class, 'show']);
    Route::post('departments', [DepartmentController::class, 'store']);
    Route::put('departments/{id}', [DepartmentController::class, 'update']);

    //order routes

    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::put('orders/{id}', [OrderController::class, 'update']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::DELETE('orders/{id}', [OrderController::class, 'destroy']);




    //Campaigns routes

    Route::get('compaigns', [CompaignController::class, 'index']);
    Route::get('compaign/{id}', [CompaignController::class, 'edit']);
    Route::post('compaigns', [CompaignController::class, 'store']);
    Route::put('compaign/{id}', [CompaignController::class, 'update']);
    Route::DELETE('compaign/{id}', [CompaignController::class, 'destroy']);


    //Account Routes

    Route::DELETE('accounts/{id}', [AccountController::class, 'delete']);
    Route::get('accounts', [AccountController::class, 'index']);
    Route::get('accounts/{id}', [AccountController::class, 'show']);
    Route::post('accounts', [AccountController::class, 'store']);
    Route::put('accounts/{id}', [AccountController::class, 'update']);



        
    //Deals routes

    Route::get('deals', [DealController::class, 'index']);
    Route::get('deals/{id}', [DealController::class, 'edit']);
    Route::post('deals', [DealController::class, 'store']);
    Route::put('deals/{id}', [DealController::class, 'update']);
    Route::DELETE('deals/{id}', [DealController::class, 'destroy']);
    Route::post('/stages',[DealController::class, 'createStage']);
    });


    });
    
    
});

