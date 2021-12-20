<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $image = $request->file('image');
        $customer = Customer::find(auth()->guard('api')->user()->id);
        if ($image) {
            $customer->review()->attach($request->product, ['star' => $request->star, 'review' => $request->review, 'image_review' => $image->hashName()]);
            $image->storeAs('public/review', $image->hashName());
        } else {
            $customer->review()->attach($request->product, ['star' => $request->star, 'review' => $request->review]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Succes Review Product'
        ]);
    }
}
