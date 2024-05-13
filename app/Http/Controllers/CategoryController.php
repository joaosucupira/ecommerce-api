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
}
