<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository) 
    {
        $this->orderRepository = $orderRepository;
    }


    

    public function index(): JsonResponse 
    {
        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('view orders','web')){

        return response()->json([
            'data' => $this->orderRepository->getAllOrders(),
            'status' => 200
        ]);
        }else {
            return response()->json([
                'message' => 'Not Authoraised'
            ]);
        }

    }

    public function store(Request $request): JsonResponse 
    {
        
        $orderDetails = $request->only([
            'client',
            'details'
            
        ]);

        return response()->json(
            [
                'data' => $this->orderRepository->createOrder($orderDetails)
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse 
    {

        $orderId = $request->route('id');

        return response()->json([
            'data' => $this->orderRepository->getOrderById($orderId)
        ]);
        }

    public function update(Request $request): JsonResponse 
    {
        $orderId = $request->route('id');
        $orderDetails = $request->all();

        return response()->json([
            'data' => $this->orderRepository->updateOrder($orderId, $orderDetails),
            'details' =>$orderDetails
        ]);
    }

    public function destroy(Request $request): JsonResponse 
    {
        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('delete orders','web')){
        $orderId = $request->route('id');
        $this->orderRepository->deleteOrder($orderId);

        return response()->json(['message' => 'deleted','status' => 200]);
        }else {
        return response()->json(['message' => 'you cant delete this','status' => 401]);

        }

    }
}
