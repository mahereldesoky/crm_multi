<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Interfaces\TeamRepositoryInterface;
use App\Models\Team;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    private TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)  {
        $this->teamRepository = $teamRepository;
    }

    public function index() : JsonResponse {
        $department = department::all();
        $roles = Role::all();
        return response()->json([
            'data' => $this->teamRepository->getAllTeam(),
            'departments' => $department,
            'roles' => $roles
        ]);
        
    }

    public function show(Request $request) : JsonResponse {
        $teamId = $request->route('id');
        $department = department::all();
        $roles = Role::all();

        return response()->json([
            'data' => $this->teamRepository->getTeamById($teamId),
            'departments' => $department,
            'roles' => $roles
        ]);
    }

    public function store(Request $request) : JsonResponse {
        $teamDetails = $request->all();
        $totalCreatedTeams = $this->teamRepository->getAllTeam()->count();
        if ($totalCreatedTeams < 10) {
        return response()->json([
            'data' => $this->teamRepository->createTeam($teamDetails),

        ],
        Response::HTTP_CREATED
        );
        }else {

        return response()->json([
            'message' => 'user limit is 10 contact us for more'
        ]);    
    }

    }
        


    public function update(Request $request) : JsonResponse {
        $teamId = $request->route('id');
        $teamDetails = $request->all();
        return response()->json([
            'data' => $this->teamRepository->updateTeam($teamId,$teamDetails),
        ]);
    }

    public function delete(Request $request) : JsonResponse {
        $teamId = $request->route('id');
        $this->teamRepository->deleteTeam($teamId);
        return response()->json(['message'=>"Deleted Successfully"]);
    }
}
