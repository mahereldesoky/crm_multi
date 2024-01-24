<?php

namespace App\Http\Controllers;

use App\Interfaces\CustomerRepositryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\ExportCustomer;
use App\Imports\ImportCustomer;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    private CustomerRepositryInterface $CustomerRepository;

    public function __construct(CustomerRepositryInterface $CustomerRepository)  {
        $this->CustomerRepository = $CustomerRepository;
    }


    public function index() : JsonResponse {
        return response()->json([
            'data' => $this->CustomerRepository->getAllCustomers()
        ]);
    }

    public function show($customerId) : JsonResponse {
        return response()->json([
            'data' => $this->CustomerRepository->getCustomerById($customerId)
        ]);
    }

    public function store(Request $request) : JsonResponse {
        $customerDetails = $request->all();
        return response()->json([
            'data' => $this->CustomerRepository->createCustomer($customerDetails)
        ],
        Response::HTTP_CREATED
        );
    }

    public function update(Request $request) : JsonResponse {
        $customerId = $request->route('id');
        $customerDetails = $request->all();
        return response()->json([
            'data' => $this->CustomerRepository->updateCustomer($customerId,$customerDetails)
        ]);
    }

    public function delete(Request $request) : JsonResponse {
        $customerId = $request->route('id');
        $this->CustomerRepository->deleteCustomer($customerId);

        return response()->json(['message' => 'deleted']);
    }

    public function importView(Request $request){
        return view('welcome');
    }

 
    public function import(Request $request) 
    {
        $import = Excel::import(new ImportCustomer, 
        $request->file('file')->store('files'));
        if($import){
            return response()->json(['message' => 'uploaded successfully']);
        }
        else {
            return response()->json(['message' => 'Something went Wrong']);

        }
    }
 
    public function exportCustomers(Request $request){
        return Excel::download(new ExportCustomer, 'customers.xlsx');
        // return  response()->json(['data' => $export]);
    }
}
