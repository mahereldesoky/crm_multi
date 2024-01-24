<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\Tenant;
use App\Models\CentralUser;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Features\UserImpersonation;

class UserController extends Controller
{


    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'email'=>'required|string|unique:users',
    //         'password'=>'required|string',
    //         'c_password' => 'required|same:password'
    //     ]);

    //     $user = new User([
    //         'name'  => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     if($user->save()){
    //         $tokenResult = $user->createToken('Token');
    //         $token = $tokenResult->plainTextToken;

    //         return response()->json([
    //         'message' => 'Successfully created user!',
    //         'accessToken'=> $token,
    //         ],201);
    //     }
    //     else{
    //         return response()->json(['error'=>'Provide proper details']);
    //     }
    // }


    /**
     * Login a user by credentials.
     *
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'user' => new UserResource($user),
            ]);
        }
        else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

    }

    public function test($token)  {
        return UserImpersonation::makeResponse($token);
    }


    public function user(Request $request )
    {
        $user = $request->user();
        $user->roles; 
        $user->Permissions;
        return response()->json($user);
        
    }


    public function store(Request $request) : JsonResponse {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|',
        ]);

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'global_id' => $request->email,
            'password' => Hash::make($request->password),
            ]);
        $user->assignRole($request->roles);
    
            return response()->json([
                'data' => $user,
                'status' => 201
            ]);
        }
    
    

    public function show($id) : JsonResponse {
        $user = User::where('id',$id)->first();
        $roles = Role::all();
        $userRole = $user->roles->pluck('name','name')->all();

        $data['user'] = $user;
        $data['roles'] = $roles;
        $data['userRole'] = $userRole;

        return response()->json($data);
    }

    public function update($id , Request $request)  {

        $user = User::where('id',$id)->first();
        $user->update([
            'name'=> $request->name ,
            'email'=> $request->email 
        ]);

        DB::table('model_has_roles')->where('model_id',$user->id)->delete();

        $user->assignRole($request->roles);

        return new UserResource($user);
    }


    public function index() : JsonResponse {
        $user = User::all();

        $data['user'] = $user;
        return response()->json([
            'data' => $data
        ]);
    }

    public function destroy($id) : JsonResponse {
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json('deleted');
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
