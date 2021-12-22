<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // validasi request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // jika email ditemukan
        $customer = Customer::where('email', $request->email)->first();
        // cek password
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'These credentials do not match our records.',
            ], 400);
        }

        // jika password valid
        return response()->json([
            'success' => true,
            'message' => 'Login Success!',
            'data' => $customer,
            'token' => $customer->createToken('authToken')->accessToken
        ]);
    }
}
