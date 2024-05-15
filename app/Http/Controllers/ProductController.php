<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
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
        }catch(\Exception $e){
            return response()->json(['message'=>'Invalid request.','error'=>$e->getMessage()], 400);
        }

       
    }

    // GET
    public function show($id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
        // return response()->json([
        //     'data' => $product
        // ]);
    }

    public function index()
    {
        $products = Product::all();
        // $product = Product::with('categories')->get();

        return response()->json($products, 200);
        // return response()->json([
        //     'data' => $product
        // ]);
    }

    // DELETE

    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Product not found.'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.'], 200);
        
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
}
