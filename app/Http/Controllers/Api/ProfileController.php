<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Profile',
            'data' => auth()->guard('api')->user()
        ]);
    }

    public function update(Request $request)
    {
        $customer = Customer::whereId(auth()->guard('api')->user()->id)->first();
        $avatar = $request->file('avatar');
        if ($avatar) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'avatar' => 'required|image|mimes:jpeg,jpg,png,svg|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            Storage::disk('local')->delete('public/customer/' . basename($customer->avatar));

            $avatar->storeAs('public/customer', $avatar->hashName());
            $customer->update([
                'name' => $request->name,
                'avatar' => $avatar->hashName()
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $customer->update([
                'name' => $request->name
            ]);
        }

        if ($customer) {
            return response()->json([
                'success' => true,
                'message' => 'Data Profile Success Updated!',
                'data' => $customer
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data Profile Failed Updated!',
        ], 400);
    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'=> 'required',
            'password' => 'required|confirmed|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (! Hash::check($request->old_password, $request->user()->password)) {
            return response()->json([
                'message' => 'The provided password does not match our records.'
                ], 400);
        }

        $password = Customer::whereId(auth()->guard('api')->user()->id)->first();
        $password->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Password Success Updated!',
            'data' => $password
        ], 201);
    }
}
