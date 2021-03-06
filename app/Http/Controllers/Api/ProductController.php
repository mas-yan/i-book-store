<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        // get product and when search
        $product = Product::when(request()->q, function ($product) {
            $product = $product->where('title', 'like', '%' . request()->q . '%');
        })->leftjoin('discounts', function ($join) {
            $join->on('discounts.product_id', '=', 'products.id')
                ->where('discounts.start', '<=', Carbon::now()->toDateString())
                ->where('discounts.end', '>', Carbon::now()->toDateString());
        })->select('products.id', 'category_id', 'title', 'author', 'slug', 'stok', 'price', 'image', 'discount', 'price_discount')->orderby('products.created_at', 'desc')->paginate(24);

        return response()->json([
            'success' => true,
            'message' => 'Get All List Data Product',
            'data' => $product
        ]);
    }

    public function show($slug)
    {
        // get product detail
        $product = Product::with(['Discount'], ['pivot' => 1])->where('slug', $slug)->first();
        $data = $product;
        $data['pivot'] = ['qty' => 1];
        return response()->json([
            'success' => true,
            'message' => 'Get Data Product ' . $product->title,
            'data' => $data,
            'count' => $product->review()->count(),
            'rating' => $product->review()->avg('star'),
            'review' => $product->review()->paginate(10),
        ]);
    }
}
