<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    /**
     * API_KEY
     *
     * @var string
     */
    protected $API_KEY = '0810fbf890b0f2354d3e7d8ab5f2566e';

    /**
     * getProvinces
     *
     * @return void
     */
    public function getProvinces()
    {

        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('http://api.rajaongkir.com/starter/province');

        $provinces = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get All Provinces',
            'data'    => $provinces
        ]);
    }

    /**
     * getCities
     *
     * @param  mixed $id
     * @return void
     */
    public function getCities($id)
    {

        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('http://api.rajaongkir.com/starter/city?&province=' . $id . '');

        $cities = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get City By ID Provinces : ' . $id,
            'data'    => $cities
        ]);
    }

    /**
     * checkOngkir
     *
     * @param  mixed $request
     * @return void
     */
    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->post('http://api.rajaongkir.com/starter/cost', [
            'origin'            => '181',
            'destination'       => $request->city_destination,
            'weight'            => $request->weight,
            'courier'           => $request->courier
        ]);

        $ongkir = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $ongkir
        ]);
    }
}
