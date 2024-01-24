<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\department;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class HomeController extends Controller
{
    public function index()  {
        
        


        return view('home');
    }



    // public function store(Request $request)
    // {
    //     $data = $request->validated();
    //     $department = new department;
    //     $department->name = $data ['name'];
    //     $department->save();

    //     if($department) {
    //         alert('done');
    //     }
    //     else {
    //         alert('dfdf');
    //     }
    // }

}
