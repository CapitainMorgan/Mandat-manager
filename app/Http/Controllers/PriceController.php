<?php

namespace App\Http\Controllers;
use App\Price;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::get();

        return view('prices',[
            'prices' => $prices,
        ]);
    }

    public function editPrice(Request $request)
    {
        $datas = $request->all();

        $price = Price::where('id',$datas['id'])->first();
        $price->name = $datas['name'];
        $price->price = $datas['price'];

        $price->save();

        return json_encode(true);
    }
}
