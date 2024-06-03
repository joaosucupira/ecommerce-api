<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\HandlesExceptions; // handleException keeps getting undefined error

class ProductController extends Controller
{
    use HandlesExceptions;
    //AUX 

    public function findCheck($id){
        $product = Product::find($id);
        if(!$product) { return response()->json(['message' => 'Product not found.'], 404); }
        return $product;
    }

    // POST
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'slug' => 'nullable|string|unique:products',
            'path'=> 'required'
        ]);

        try{
             $product = Product::create($validated);
            return response()->json(compact('product'), 201);

        } catch(\Exception $e){ return response()->json(['message'=>'Invalid request.','error'=>$e->getMessage()], 400); }
    }

    // GET
    public function show($id)
    {
        $product = $this->findCheck($id);
        return response()->json($product, 200);
    }

    public function index()
    {
        $products = Product::all();
        // $products = Product::with('categories')->get();
        return response()->json($products, 200);
    }

    // DELETE
    public function destroy($id)
    {
        $product = $this->findCheck($id);
        $product->delete();
        return response()->json(['message' => "Product $product->name deleted successfully."], 200);
    }

    // PUT
    public function update(Request $request, $id){
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found.'], 404);
        }
        
        $request->validate([
            'name' => 'string',
            'price' => 'decimal',
            'active' => 'boolean',
            'path'=> 'string'
        ]);

        $product->update($request->all());
        $product->save();
        return response()->json([['message' => 'Product updated successfully.'], 200]);
    }

    // RELATIONS
    public function categories($id)
    {
        try {
            $product = Product::with('categories')->findOrFail($id);
            $categories = $product->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            });

            return response()->json($categories, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);

        
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
        // } catch(\Exception $e){
        //     return $this->handleException($e);
        // } // ! - undefined error
    }

    public function orders($productId) {
        $product = $this->findCheck($productId);
        $orders = $product->orders;
        return response()->json($orders, 200);
    }

}
