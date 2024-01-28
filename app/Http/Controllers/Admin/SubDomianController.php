<?php

namespace App\Http\Controllers\Admin;

use DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Tenant;
use App\Models\UserVerify;
use App\Models\CentralUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Stancl\Tenancy\Database\Models\Domain;


class SubDomianController extends Controller
{
    public function index()  {
        $tenants = tenant::all();
        $domains = Domain::all();

        foreach ($tenants as $tenant){
            foreach ( $tenant->domains as $domain){
                $domains = $domain->domain;
            }    
        }
                

        return view('welcome', compact('tenants', 'domains'));
    }

    public function store(Request $request)  {
        $validatedData = $request->validate([
            'subdomain' =>'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        $user = CentralUser::create([
            'global_id' => $request->subdomain,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $tenant = Tenant::create([
            'id' =>  $request->subdomain,
            'global_id' => $request->subdomain,
            'subdomain' => $request->subdomain,
            'name' =>  $request->name,
            'email' =>  $request->email,
            'password' =>  bcrypt($request->password),
        ]);
        
        $user->tenants()->attach($tenant);
        $tenant->domains()->create(['domain' => $validatedData['subdomain'] . '.217.196.50.196']);

        $tenant->run(function (){
            $user = User::where('id',1)->first();
            $user->assignRole('CEO');
        });
        $verify_token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $user->id, 
              'token' => $verify_token
            ]);
  
        Mail::send('emails.emailVerificationEmail', ['token' => $verify_token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Email Verification Mail');
          });
        return redirect('/')->with('message', "Account successfully registered.");
     
        // $redirect_url = 'http://'.$tenant->subdomain.'.localhost:5173/';
        // $token = tenancy()->impersonate($tenant,$user->global_id,$redirect_url);
        // $tenant_url = "http://{$tenant->subdomain}.localhost:8000";
        // return redirect("{$tenant_url}/impersonate/{$token->token}");
        }
        
        public function verifyAccount($token){

            $verifyUser = UserVerify::where('token', $token)->first();
      
            $message = 'Sorry your email cannot be identified.';
      
            if(!is_null($verifyUser) ){
                $user = $verifyUser->user;
                  
                if(!$user->email_verified_at) {
                    $verifyUser->user->email_verified_at = Carbon::now();
                    $verifyUser->user->save();
                    $message = "Your e-mail is verified. You can now login.";
                } else {
                    $message = "Your e-mail is already verified. You can now login.";
                }
            }
      
          return redirect('/')->with('message', $message);
        }
        
       
    public function loginForm()  {
        return view('auth.login');
    }

    public function login(Request $request)  {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if($user->email_verified_at != null){
            $userId = $user->id;
            $userData = \DB::table('tenant_users')->where('global_user_id',$user->global_id)->first();
            $tenant = Tenant::where('id',$userData->tenant_id)->first();
            $redirect_url = 'http://'.$tenant->subdomain.'.localhost:5173/';
            $token = tenancy()->impersonate($tenant,$user->global_id,$redirect_url);
            $tenant_url = "http://{$tenant->subdomain}.localhost:8000";
            Auth::logout();
            return redirect("{$tenant_url}/impersonate/{$token->token}");
        }
        else{
            Auth::logout();
            return redirect('/')->with('message',"please verfiy your email");
        }
        }
        else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }



    public function apiData() : JsonResponse {
        $tenants = Tenant::all();
        $allDomain = Domain::all();


        return response()->json($allDomain);
    }
}


