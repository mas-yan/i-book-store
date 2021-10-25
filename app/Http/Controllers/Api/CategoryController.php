<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // get data Category 
        $categories = Category::latest()->paginate(5);

        // return json category
        return  response()->json([
            'success' => true,
            'message' => 'List All Data Category',
            'data' => $categories
        ]);
    }

    public function category()
    {
        // get category
        $categories = Category::latest()->take('5')->get();

        // return json category
        return response()->json([
            'success' => true,
            'message' => 'List Data Category',
            'data' => $categories
        ]);
    }

    public function show($slug)
    {
        // get detail category with product
        $categories = Category::with('products')->where('slug', $slug)->first();

        if ($categories) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Campaign Berdasarkan Category : ' . $categories->name,
                'data' => $categories
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'List Data Category Not Found',
            'data' => $categories
        ]);
    }
}
