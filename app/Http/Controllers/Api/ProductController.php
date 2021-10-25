<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::latest()->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Gest All List Data Product',
            'data' => $product
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        return response()->json([
            'success' => true,
            'message' => 'Get Data Product ' . $product->title,
            'data' => $product
        ]);
    }
}
