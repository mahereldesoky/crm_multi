<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{


    // function __construct()
    // {
    //      $this->middleware('permission:view|create|edit|delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:create orders', ['only' => ['create','store']]);
    //      $this->middleware('permission:edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:delete', ['only' => ['destroy']]);
    // }




    public function index() : JsonResponse {
        $user = User::find(Auth::user()->id);
        if($user->can('view roles','web')){
        $roles = Role::all();
        $permissions = Permission::all();
        return response()->json([
            'data' => $roles,
            'permissions' => $permissions,
            'status' => 200
        ]);
        }
        else {
        return response()->json([
            'message' => 'You Cant View Roles',
            'status' => 402
        ]);
        }
    }

    public function store(Request $request) : JsonResponse {
        $user = User::find(Auth::user()->id);
        if($user->can('create roles','web')){

            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);
        
            // $role = Role::create(['name' => $request->input('name') , 'guard_name' => 'web']);
            // $role->syncPermissions([$request->input('permission') , 'guard_name' => 'web']);

            $role = Role::create(['name' => $request->input('name') , 'guard_name' => 'web']);
            $role->syncPermissions( $request->permission);
            // $permission = Permission::create(['name' => $request->input('permission') , 'guard_name' => 'web']);
           
            return response()->json([
                'data'=> 'Created succssfully',
                'status' => 200
            ],
            Response::HTTP_CREATED
            );
        }else {
            return response()->json([
                'message' => 'You Cant Add Roles',
                'status' => 402

            ]);
        }
        

    }


    public function  createPermissions(Request $request) : JsonResponse {
        // $admin = Auth::user();
        // if($admin->hasAnyRole(['manager', 'admin'])) {
            $this->validate($request, [
                'name' => 'required|unique:permissions,name',
            ]);
        
            // $role = Role::create(['name' => $request->input('name') , 'guard_name' => 'web']);
            // $role->syncPermissions([$request->input('permission') , 'guard_name' => 'web']);

            
            Permission::create(['name' => $request->input('name') , 'guard_name' => 'web']);
           
            return response()->json([
                'data'=> 'Created succssfully'
            ],
            Response::HTTP_CREATED
            );
        // }
    }


    public function show($id) : JsonResponse {
        
            $role = Role::find($id);
            $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permission_id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
           
            return response()->json([
                'data'=> $role,
                'permissions' => $rolePermissions,
            ]);
            
    }

    public function edit($id) : JsonResponse {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")
        ->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return response()->json([
            'data'=> $role,
            'permissions' => $permission,
            'rolepermissions' => $rolePermissions
        ]);
        
    }




    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permission);
    
    
        return response()->json([
            'data' => 'updated'
        ]);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if($role){
            $role->delete();
        return response()->json([
            'data' => 'deleted'
        ]);
    }

    }
}
