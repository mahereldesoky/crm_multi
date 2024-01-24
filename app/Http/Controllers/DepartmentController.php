<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\DepartmentRepositoryInterface;

class DepartmentController extends Controller
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;

    }

    public function index() : JsonResponse {
        $user = User::find(Auth::user()->id);
        if($user->can('create roles','web')){
        return response()->json([
            'data' => $this->departmentRepository->getAllDepartments()
        ]);
        }else {
        return response()->json([
            'message' => 'You Cant Add Roles',
            'status' => 402

        ]);
    }
    }

    public function store(Request $request) : JsonResponse {
        $departmentDetails = $request->all();
        return response()->json([
            'data'=> $this->departmentRepository->createDepartment($departmentDetails)
        ],
        Response::HTTP_CREATED
        );
    }

    public function show(Request $request) : JsonResponse {
        $departmentId =  $request->route('id');
        return response()->json([
            'data'=> $this->departmentRepository->getDepartmentById($departmentId)
        ]);
        
    }

    public function update(Request $request) : JsonResponse {
        
        $departmentId = $request->route('id');
        $departmentDetails = $request->all();
        return response()->json([
            'data' => $this->departmentRepository->updateDepartment($departmentId,$departmentDetails)
        ]);

    }

    public function delete(Request $request) : JsonResponse {
        $departmentId = $request->route('id');
        $this->departmentRepository->deleteDepartment($departmentId);
        return response()->json([
            'message'=>'deleted'
        ]);
    }
}
