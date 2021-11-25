<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::leftjoin('discounts', function ($join) {
            $join->on('discounts.product_id', '=', 'products.id')
                ->where('discounts.start', '<=', Carbon::now()->toDateString())
                ->where('discounts.end', '>', Carbon::now()->toDateString());
        })->select('products.id', 'category_id', 'title', 'slug', 'stok', 'price', 'image', 'discount', 'price_discount')->orderby('products.created_at', 'desc')->paginate(24);
        return response()->json([
            'success' => true,
            'message' => 'Get All List Data Product',
            'data' => $product
        ]);
    }

    public function show($slug)
    {
        $product = Product::with('Discount')->where('slug', $slug)->first();
        return response()->json([
            'success' => true,
            'message' => 'Get Data Product ' . $product->title,
            'data' => $product
        ]);
    }
}
