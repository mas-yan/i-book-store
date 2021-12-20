<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::when(request()->q, function ($product) {
            $product = $product->where('title', 'like', '%' . request()->q . '%');
        })->leftjoin('discounts', function ($join) {
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
        $product = Product::with(['Discount'], ['pivot' => 1])->where('slug', $slug)->first();
        $data = $product;
        $rate = DB::table('reviews')
            ->select(DB::raw('round(AVG(star),0) as star'))
            ->first();
        $data['pivot'] = ['qty' => 1];
        return response()->json([
            'success' => true,
            'message' => 'Get Data Product ' . $product->title,
            'data' => $data,
            'count' => $product->review()->count(),
            'rating' => $rate->star,
            'review' => $product->review()->paginate(10),
        ]);
    }
}


// DB::table('reviews')
            // ->select(DB::raw('round(AVG(star),0) as star'))
            // ->first();
