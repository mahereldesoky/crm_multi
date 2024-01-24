<?php

namespace App\Http\Controllers;

use App\Interfaces\AccountRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private AccountRepositoryInterface $AccountRepository;

    public function __construct(AccountRepositoryInterface $AccountRepository)
    {
        $this->AccountRepository = $AccountRepository;
    }


    public function index() : JsonResponse {

        $data = $this->AccountRepository->getAllAccounts();
        if($data){
        return response()->json([
            'data' => $data,
            'message' => "success",
            'status' => 200
        ]);
        }
        else{
            return response()->json([
                'message' => 'something went wrong'
            ]);
        }
    }

    public function show($accountId) : JsonResponse {
        $data =  $this->AccountRepository->getAccountById($accountId);

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(Request $request) : JsonResponse {
        $AccountDetails = $request->all();
        $data = $this->AccountRepository->createAccount($AccountDetails);
        if($data){
            return response()->json([
                'data' => $data,
                'message' => "success",
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'something went wrong'
            ]);
        }
    }

    public function update(Request $request , $accountid) : JsonResponse {
        $accountid = $request->route('id');
        $accountDetails = $request->all();
        $data = $this->AccountRepository->updateAccount($accountid , $accountDetails);
        if($data){
            return response()->json([
                'data' => $data,
                'message' => "Updated",
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'something went wrong'
            ]);
        }
    }

    public function destroy(Request $request) : JsonResponse {
        $accountid = $request->route('id');
        $data = $this->AccountRepository->deleteAccount($accountid);
        if($data){
            return response()->json([
                'data' => $data,
                'message' => "Deleted",
                'status' => 200
            ]);
        }else{
            return response()->json([
                'message' => 'something went wrong'
            ]);
        }
    }





}
