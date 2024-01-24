<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Campaigns;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Stage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DealController extends Controller
{
    public function index() : JsonResponse {

        $customers = Customer::all();
        $compaigns = Campaigns::all();
        $accounts = Account::all();
        $stages = Stage::all();
        $deal = Deal::all();
        // foreach($stages as $stage){

        // }

        // $deal = Deal::where('stage_id',$stage->id)->get();

        // $stages = Stage::where('id',$deals->stage_id)->first();
        
        // $deal = Deal::where('stage_id', $stages->id)->get();

        // foreach ($dealData as $dealDat) {
        //     $id = $dealDat->id;
        // }

        // $deal = $stages->where('id',$id )->first();
        return response()->json([
            'deal' => $deal,
            'customers' => $customers,
            'compaigns' => $compaigns,
            'accounts' => $accounts,
            'stages' => $stages
        ]);


        
    }

    public function store(Request $request) : JsonResponse {
        $data = $request->validate([
            'user_id' => 'numeric',
            'customer_id' => 'numeric',
            'account_id' => 'numeric',
            'compaign_id' => 'numeric',
            'name' => 'string',
            'type'  => 'string',
            'lead_src'  => 'string',
            'stage_id'  => 'numeric',
            'amount'  => 'numeric',
            'probability'  => 'numeric',
            'description'  => 'string',
            'closedate'  => 'date',

        ]);
        $stage = Stage::find($data['stage_id']);
        $deals = $stage->deals()->create($data);
        if ($data) {
            return response()->json([
                'data' => $deals,
                'message' => 'Successfully added new deal!',
                'status' => 200
            ]);
        }
        else {
            return response()->json(['message'=>'Error adding a new deal']);
        }
        }


        public function edit($id) : JsonResponse {
            $stages = Stage::all();
            $deal = Deal::find($id);
            return response()->json([
                'data'=> $deal,
                'stages' => $stages
            ]);
        }


        public function update(Request $request, $id)
        {
            
            $data = $request->validate([
                // 'user_id' => 'numeric',
                // 'customer_id' => 'numeric',
                // 'account_id' => 'numeric',
                // 'compaign_id' => 'numeric',
                // 'name' => 'string',
                // 'type'  => 'string',
                // 'lead_src'  => 'string',
                'stage_id'  => 'numeric',
                'amount'  => 'numeric',
                // 'probability'  => 'numeric',
                // 'description'  => 'string',
                // 'closedate'  => 'date',
    
            ]);
            $deal = Deal::where('id', $id)->first();
    
                    if($deal){
                        $deal->update($data);
           
                return response()->json([
                    'message' => 'Successfully updated deal!',
                    'status' => 200
                ]);
            }
    
        }

        
    public function  createStage(Request $request) : JsonResponse {
            $this->validate($request, [
                'name' => 'required|unique:stages,name',
            ]);

            Stage::create(['name' => $request->input('name')]);
           
            return response()->json([
                'message' => 'Successfully updated deal!',
                'status' => 200
            ],
            );
    }
    
        public function destroy($id)
        {
            $deal = Deal::find($id);
            if($deal){
                $deal->delete();
            return response()->json([
                'data' => 'deleted'
            ]);
        }



    
    }
}

