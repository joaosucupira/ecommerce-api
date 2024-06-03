<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\HandlesExceptions;

class CategoryController extends Controller
{
    use HandlesExceptions;

    // AUX
    public function findCheck($id){
        $category = Category::find($id);
        if(!$category) { return response()->json(['message' => 'Category not found.'], 404); }
        return $category;
    }

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
        // $category = Category::find($id);
        // if(!$category) { return response()->json(['message' => 'Category not found.'], 404); }
        $category = $this->findCheck($id);
        return response()->json($category, 200);
    }

    public function index(){
        $categories = Category::with('products')->get();
        // $categories = Category::all();

        // return response()->json([
        //     'data' => $category
        // ]);
        return response()->json($categories, 200);
    }

    public function update(Request $request, $id){
        $category = Category::find($id);
        if(!$category) { return response()->json(['message' => 'Category not found.'], 404); }
        $old_name = $category->name;

        $request->validate(['name' => 'string',]);
        $category->update($request->all());
        $category->save();
        return response()->json([['message' => "Category $old_name updated successfully to $category->name."], 200]);

    }

    public function destroy($id) {
        // $category = Category::find($id);
        // if(!$category) { return response()->json(['message' => 'Category not found.'], 404); }
        $category = $this->findCheck($id);
        $category->delete();
        return response()->json([['message' => "Category $category->name deleted successfully."]]);
    }

    public function products($id) {
        try {
            // $category = Category::findOrFail($categoryId);
            $category = $this->findCheck($id);
            $products = $category->products;
            return response()->json($products, 200);

        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


}
