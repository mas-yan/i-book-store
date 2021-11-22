<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class OrderController extends Controller
{

    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        $order = Order::where('customer_id', auth()->guard('api')->user()->id)->latest()->paginate(5);
        return response()->json([
            'success' => true,
            'message' => 'List Orders Customer',
            'data' => $order
        ]);
    }

    public function show(Order $invoice)
    {
        return response()->json([
            'success' => true,
            'message' => 'List Orders Customer',
            'data' => $invoice
        ]);
    }


    public function addCart(Product $product)
    {
        $customer = Customer::find(auth()->guard('api')->user()->id);
        $cart = $product->customer()->first();
        if ($cart) {
            $cart->pivot->qty += 1;
            $cart->pivot->save();
        } else {
            $product->customer()->attach($customer, ['qty' => 1]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Add Cart',
            'data' => $product
        ]);
    }

    public function transaction(Request $request)
    {
        try {
            DB::beginTransaction();

            /**
             * algorithm create no invoice
             */
            $length = 10;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = 'TRX-' . Str::upper($random);

            $order = Order::create([
                'customer_id' => auth()->guard('api')->user()->id,
                'invoice' => $no_invoice,
                'status' => 'pending',
                'phone' => $request->phone,
                'full_name' => $request->full_name,
                'city' => $request->city,
                'province' => $request->province,
                'address' => $request->address,
                'service' => $request->service,
                'courir' => $request->courir,
                'cost' => $request->cost,
                'grand_total' => $request->grand_total,
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $order->invoice,
                    'gross_amount' => $order->grand_total
                ],
                'customer_detail' => [
                    'first_name' => auth()->guard('api')->user()->name,
                    'email' => auth()->guard('api')->user()->email
                ]
            ];

            $snapToken = Snap::getSnapToken($payload);
            $order->snap_token = $snapToken;
            $order->save();

            $customer = Customer::find(auth()->guard('api')->user()->id);

            foreach ($customer->product as $item) {
                $order->product()->attach($item->id, ['qty' => $item->pivot->qty]);
            }

            $customer->product()->detach();

            $this->response['snap_token'] = $snapToken;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json([
            'success' => true,
            'message' => 'Order Berhasil Dibuat!',
            $this->response
        ]);
    }

    public function notificationHandler(Request $request)
    {
        $payload      = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }
        $transaction = $notification->status;
        $type         = $notification->payment_type;
        $orderId      = $notification->order_id;
        $fraud        = $notification->fraud_status;

        $data_order = Order::where('invoice', $orderId)->first();

        if ($transaction == 'capture') {

            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {

                if ($fraud == 'challenge') {

                    /**
                     *   update invoice to pending
                     */
                    $data_order->update([
                        'status' => 'pending'
                    ]);
                } else {

                    /**
                     *   update invoice to success
                     */
                    $data_order->update([
                        'status' => 'success'
                    ]);
                }
            }
        } elseif ($transaction == 'settlement') {

            /**
             *   update invoice to success
             */
            $data_order->update([
                'status' => 'success'
            ]);
        } elseif ($transaction == 'pending') {


            /**
             *   update invoice to pending
             */
            $data_order->update([
                'status' => 'pending'
            ]);
        } elseif ($transaction == 'deny') {


            /**
             *   update invoice to failed
             */
            $data_order->update([
                'status' => 'failed'
            ]);
        } elseif ($transaction == 'expire') {


            /**
             *   update invoice to expired
             */
            $data_order->update([
                'status' => 'expired'
            ]);
        } elseif ($transaction == 'cancel') {

            /**
             *   update invoice to failed
             */
            $data_order->update([
                'status' => 'failed'
            ]);
        }
    }
}
