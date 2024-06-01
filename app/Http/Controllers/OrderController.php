<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // POST
    public function store(Request $request)
    {
        $requestData = $request->validate(['code' => 'required|integer|unique:orders',]);
        $order = Order::create($requestData);
        return response()->json($order, 201);
    }

    // GET
    public function index(){
        $orders = Order::all();
        return response()->json($orders, 200);
    }

    public function show($id){
        $order = Order::findOrFail($id);
        return response()->json($order, 200);
    }

    // PUT
    public function update(Request $request, $id){
        $order = Order::findOrFail($id);

        $requestData = $request->validate([
            'code' => 'required|integer|unique:orders,code,' . $order->id,
        ]);

        $order->update($requestData);
        return response()->json($order, 200);
    }
    
    // DELETE
    public function destroy($id){
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}
