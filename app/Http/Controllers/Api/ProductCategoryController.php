<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::all();
        return response()->json($productCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'category_id' => 'required|exists:categories,id',
            ]);

            $productCategory = ProductCategory::create([
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
            ]);

            return response()->json($productCategory, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $productCategory = ProductCategory::findOrFail($id);

            return response()->json($productCategory, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'ProductCategory not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'category_id' => 'required|exists:categories,id',
            ]);

            $productCategory = ProductCategory::findOrFail($id);
            $productCategory->update([
                'product_id' => $request->product_id,
                'category_id' => $request->category_id,
            ]);

            return response()->json($productCategory, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'ProductCategory not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $productCategory = ProductCategory::findOrFail($id);
            $productCategory->delete();

            return response()->json([
                'message' => 'Relation deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Relation not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
