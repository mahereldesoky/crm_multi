<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Customer;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use App\Interfaces\LeadsRepositoryInterface;

class LeadrController extends Controller
{
    private LeadsRepositoryInterface $leadRepository;

    public function __construct(LeadsRepositoryInterface $leadRepository)  {
        $this->leadRepository = $leadRepository;
    }

    public function index() : JsonResponse {
        $customers = Customer::all();
        $team = Team::all();

        return response()->json([
            'data' => $this->leadRepository->getAllLeads(),
            'customers' => $customers,
            'teams' => $team,
        ]);
    }

    public function show($leadId) : JsonResponse {
        $customers = Customer::all();
        $team = Team::all();
        return response()->json([
            'data' => $this->leadRepository->getLeadById($leadId),
            'customer' => $customers,
            'team' => $team,
        ]);
    }

    public function store(Request $request) : JsonResponse {
        $leadDetails = $request->all();
       
        return response()->json([
            'data' => $this->leadRepository->createLeads($leadDetails),
            
        ]);
    }

    public function update(Request $request) : JsonResponse {
        $leadId = $request->route('id');
        $leadDetails = $request->all();

        return response()->json([
            'data' => $this->leadRepository->updateLead($leadId,$leadDetails)
        ]);
    }

    public function delete(Request $request) : JsonResponse {
        $leadId = $request->route('id');
        $this->leadRepository->deleteLead($leadId);

        return response()->json(['message' => 'deleted']);
    }



}
