<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index()
    {
        // get data Category 
        $categories = Category::orderby('name', 'asc')->paginate(24);

        // return json category
        return  response()->json([
            'success' => true,
            'message' => 'List All Data Category',
            'data' => $categories
        ]);
    }

    public function random()
    {
        // get 12 data random category
        $categories = Category::inRandomOrder()->limit(12)->get();
        // get username customer login
        return response()->json([
            'success' => true,
            'message' => 'List Data Category',
            'data' => $categories
        ]);
    }

    public function category()
    {
        // get category
        $categories = Category::latest()->take('4')->get();

        // return json category
        return response()->json([
            'success' => true,
            'message' => 'List Data Category',
            'data' => $categories
        ]);
    }

    public function show($slug)
    {
        // find category
        $categories = Category::where('slug', $slug)->first();

        // get detail category with product
        $product = Product::where('category_id', $categories->id)->leftjoin('discounts', function ($join) {
            $join->on('discounts.product_id', '=', 'products.id')
                ->where('discounts.start', '<=', Carbon::now()->toDateString())
                ->where('discounts.end', '>', Carbon::now()->toDateString());
        })->select('products.id', 'category_id', 'title', 'author', 'slug', 'price', 'image', 'discount', 'price_discount')->orderby('products.created_at', 'desc')->paginate(24);

        // jika category ditemukan
        if ($categories) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Campaign Berdasarkan Category : ' . $categories->name,
                'category' => $categories,
                'data' => $product
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'List Data Category Not Found',
            'data' => $categories
        ]);
    }
}
