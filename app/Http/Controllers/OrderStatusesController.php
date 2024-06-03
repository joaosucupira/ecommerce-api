<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusesController extends Controller
{

    // VALID STATUSES
    private $validStatuses = ['Pending', 'Processing', 'Completed', 'Cancelled'];

    // AUX
    public function findCheck($id){
        $orderStatus = OrderStatus::find($id);
        if (!$orderStatus) {
            return response()->json(['message' => 'Order status not found.'], 404);
        }
        return $orderStatus;
    }

    // POST
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|string|in:' . implode(',', $this->validStatuses),
        ]);

        $orderStatus = OrderStatus::create($requestData);
        return response()->json($orderStatus, 201);
    }

    // GET
    public function index()
    {
        $orderStatuses = OrderStatus::all();
        return response()->json($orderStatuses, 200);
    }

    public function show($id)
    {
        $orderStatus = $this->findCheck($id);
        return response()->json($orderStatus, 200);
    }

    // PUT
    public function update(Request $request, $id)
    {
        $orderStatus = $this->findCheck($id);

        $requestData = $request->validate([
            'status' => 'required|string|in:' . implode(',', $this->validStatuses),
        ]);

        $orderStatus->update($requestData);
        return response()->json($orderStatus, 200);
    }

    // DELETE
    public function destroy($id)
    {
        $orderStatus = $this->findCheck($id);
        $orderStatus->delete();
        return response()->json(null, 204);
    }

    // RELATIONS
    public function orderStatuses($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $orderStatuses = $order->orderStatuses;
        return response()->json($orderStatuses, 200);
    }
}
