<?php

namespace App\Http\Controllers\Setup;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
     /**
     * This function is used to return View of Account Setup
     * @method GET /setup/account/
     * @return Renderable
     */

     public function account()
     {
         return view('setup.account');
     }
 
         /**
      * This function is used to create the user Account
      * @param Request
      * @method POST /setup/account-submit/
      * @return Renderable
      */
 
     public function accountSubmit(Request $request)
     {
         try {
             $request->validate([
                 'name' => 'required',
                 'email' => 'required|email',
                 'profile_pic' => 'max:2048|mimes:png,jpg,jpeg,gif',
                 'password' => 'required|',
             ]);
             $profilePic = saveImage($request->profile_pic, 'img/profile');
             $user = User::where('email', $request->email)->where('password',$request->password)->where('name',$request->name)->first();
            //  User::updateOrCreate([
            //      'email' => $request->email,
            //  ],[
            //      'name' => $request->name,
            //      'email' => $request->email,
            //      'profile_pic' => $profilePic,
            //      'role_id' => 1,
            //      'password' => Hash::make($request->password),
            //  ]);
            if($user){
                
            
             $stage = Configuration::where('config', 'setup_stage')->firstOrFail()->update(['value' => '2']);
             return redirect()->route('setup.configuration');
            }
            else{
                return redirect()->route('setup.account')->with('message','un valid credntials');
            }
         } catch (Exception $e) {
             return redirect()->route('setup.account')->withInput()->withErrors([$e->getMessage()]);
         }
     }
}
