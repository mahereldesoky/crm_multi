<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campaigns;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompaignController extends Controller
{
    public function index() : JsonResponse {
        $user = User::find(Auth::user()->id);
        if($user->can('view compaigns','web')){
        $campaigns = Campaigns::all();
        
        return response()->json([
            'data' => $campaigns,
            'status' => 200
            
        ]);
        }
        else {
        return response()->json([
            'message' => 'You Cant View Compaigns',
            'status' => 402
        ]);
        }
    }

    public function store(Request $request) : JsonResponse {
    // Validate the request...
    $data = $request->validate([
        'user_id' => 'numeric',
        'name' => ['required', 'string'],
        'description' => 'string',
        'start_at' => 'date',
        'end_at' => 'date|after:start_at',
        'bud_cost' => 'numeric',
        'Act_cost' => 'numeric', 
        'num_sent' => 'numeric', 
        'exp_revenue' => 'numeric', 
        'expect_res' => 'string', 
        'status' => 'string',
        'type' => 'string'

    ]);

    if ($data) {
        $campaign = Campaigns::create($data);
        return response()->json([
            'data' => $campaign,
            'message' => 'Successfully added new campaign!',
            'status' => Response::HTTP_CREATED
        ]);
    }
    else {
        return response()->json(['error'=>'Error adding a new campaign']);
    }
    }


    // public function show($id) : JsonResponse {
    //     $campaign = Campaigns::find($id);
    //     return response()->json([
    //         'data'=> $campaign,
    //     ]);
    // }


    public function edit($id) : JsonResponse {
        $campaign = Campaigns::find($id);
        return response()->json([
            'data'=> $campaign,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'numeric',
            'name' => ['required', 'string'],
            'description' => 'string',
            'start_at' => 'date',
            'end_at' => 'date|after:start_at',
            'bud_cost' => 'numeric',
            'Act_cost' => 'numeric', 
            'num_sent' => 'numeric', 
            'exp_revenue' => 'numeric', 
            'expect_res' => 'string', 
            'status' => 'string',
            'type' => 'string'
    
        ]);
    
        if ($data) {
            $campaign = Campaigns::find($id);
            $campaign->update($data);
            return response()->json([
                'data' => $campaign,
                'message' => 'Successfully updated  campaign!',
                'status' => 200
            ]);
        }

    }

    public function destroy($id)
    {
        $campaign = Campaigns::find($id);
        if($campaign){
            $campaign->delete();
        return response()->json([
            'data' => 'deleted'
        ]);
    }

    }



}
