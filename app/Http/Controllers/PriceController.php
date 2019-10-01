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
}
