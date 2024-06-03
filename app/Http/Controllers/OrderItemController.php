<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    //AUX
    public function findCheck($id){
        $orderItem = OrderItem::find($id);
        if(!$orderItem) { return response()->json(['message' => 'orderItem not found.'], 404); }
        return $orderItem;
    }
    // GET
    public function index() {
        $orderItem = OrderItem::all();
        return response()->json($orderItem, 200);
    }
    public function show($id) {
        $orderItem = $this->findCheck($id);
        return response()->json($orderItem, 200);

    }
    // POST
    public function store(Request $request) {
        $requestData = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:1',
        ]);

        // $orderItem = OrderItem::create($requestData);
        // return response()->json($orderItem, 201);
        try {
            $order = Order::findOrFail($requestData['order_id']);
            $product = Product::findOrFail($requestData['product_id']);

            $orderItem = OrderItem::create($requestData);
            return response()->json($orderItem, 201);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Order or Product not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);
        }

    }
    
    // PUT
    public function update(Request $request, $id){
        $orderItem = $this->findCheck($id);

        $requestData = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $orderItem->update($requestData);
        return response()->json($orderItem, 200);
    }
    // DELETE
    public function destroy() {
        $orderItem = $this->findCheck($id);
        $orderItem->delete();
        return response()->json(null, 204);

    }
    // RELATIONS
    public function order($orderItemId) {
        $orderItem = $this->findCheck($orderItemId);
        $order = $orderItem->order;
        return response()->json($order, 200);
    }

    public function product($orderItemId) {
        $orderItem = $this->findCheck($orderItemId);
        $product = $orderItem->product;
        return response()->json($product, 200);
    }
}
