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
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'slug' => 'required|string|unique:products',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            // 'slug' => $request->slug,
            // 'slug' => $request->Str::of('Laravel Framework')->slug('-'),
            'slug' => Str::slug($request->name),
        ]);

        return response()->json($product, 201);
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
        ]);

        $product->update($request->all());

        $product->save();
        return response()->json([['message' => 'Product updated successfully.'], 200]);

    }
}
