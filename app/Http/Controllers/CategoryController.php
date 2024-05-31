<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    // POST
    public function store(Request $request){

        $request->validate([
            'name' => 'required|string',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category, 201);
    }

    // GET
    public function show($id){
        $category = Category::findOrFail($id);

        return response()->json($category, 200);
    }

    public function index(){
        $category = Category::with('products')->get();

        return response()->json([
            'data' => $category
        ]);
    }

    //PRODUCT - testes
    public function product(Request $request, $categoryId){
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);
            $category = Category::findOrFail($categoryId);
            $product = Product::findOrFail($request->product_id);
            // ! - Use of attach()
            $category->products()->attach($product);

            return response()->json([
                'message' => 'Producted categorized successfully.',
                'category' => $category
            ], 200);

        } catch (ValidationException $e) {
            // 422 - validation
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->erros()
            ], 422);

        } catch (ModelNotFoundException $e) {
            // 404 - not found
            return response()->json([
                'message' => 'Category or Product not found'
            ], 404);

        } catch (\Exception $e) {
            // 500 - internal error
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
        
    } 
}
