<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    //AUX

    public function findCheck($id){
        $order = Order::find($id);
        if(!$order) { return response()->json(['message' => 'order not found.'], 404); }
        return $order;
    }

    private function generateOrderCode(){
        do {
            $code = rand(100000, 999999);
        } while (Order::where('code', $code)->exists());
        return $code;
    }

    // POST
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1'
        ]);
        $code = $this->generateOrderCode();
        

        // $order = Order::create([
        //     'user_id' => $request->user_id,
        //     'code' => $code,
        // ]);

        try {
            $user = User::findOrFail($request['user_id']);
            if(empty($request['order_items'])) {
                return response()->json(['message' => 'No order items provided.', 400]);
            }
            $order = Order::create([
                'user_id' => $request['user_id'],
                'code' => $code,
            ]);

            foreach($request['order_items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            OrderStatus::create([
                'order_id' => $order->id,
                'status' => 'Processing'
            ]);

            return response()->json($order->load('orderItems'), 201);


        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User or Product not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error ocurred.','error' => $e->getMessage()], 500);
        }


    }

    // GET
    public function index(){
        $orders = Order::with('orderItems')->get();
        return response()->json($orders, 200);
    }

    public function show($id){
        $order = $this->findCheck($id);
        return response()->json($order, 200);
    }

    // PUT
    public function update(Request $request, $id){
        $order = $this->findCheck($id);

        $requestData = $request->validate([
            'code' => 'required|integer|unique:orders,code,' . $order->id,
        ]);

        $order->update($requestData);
        return response()->json($order, 200);
    }
    
    // DELETE
    public function destroy($id){
        $order = $this->findCheck($id);
        $order->delete();
        return response()->json(null, 204);
    }

    // RELATIONS
    public function orderItems($id) {
        $order = $this->findCheck($id);
        $orderItems = $order->orderItems;
        return response()->json($orderItems, 200);
    }

    // public function addProduct(Request $request, $orderId) {
    //     $order = $this->findCheck($orderId);

    //     $requestData = $request->validate([
    //         'product_id' => 'required|exists:products, id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     $orderItem = OrderItem::create([
    //         'order_id' => $order->id,
    //         'product_id' => $requestData['product_id'],
    //         'quantity' => $requestData['quantity'],
    //     ]);

    //     return response()->json($orderItem, 201);
    // }

    // public function removeProduct($orderId, $orderItemId) {
    //     $order = $this->findCheck($orderId);
    //     $orderItem = $this->findCheck($orderItemId);

    //     $orderItem->delete();

    //     return response()->json(null, 204);
    // }
}
