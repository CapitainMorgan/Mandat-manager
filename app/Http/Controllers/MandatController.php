<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mandate;
use App\Workon;
use App\Price;

class MandatController extends Controller
{
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mandate = Mandate::join('workon','id','=','workon.idMandate')->where("workon.idUser","=",auth()->user()->id)->get();

        return view('mandate.mandates',[
            'mandate' => $mandate,
        ]);
    }

    public function show($mandate_id)
    {
        $mandate = Mandate::where('id',$mandate_id)->first();

        return view('mandate.show',[
            'mandate' => $mandate,
        ]);
    }

    public function create()
    {
        return view('mandate.create',[]);
    }

    public function store(Request $request)
    {
      $datas = $request->all();

      $mandate = new Mandate;
      $mandate->name = $datas['name'];
      $mandate->start = $datas['start'];
      $mandate->end = $datas['end'];
      $mandate->comment = $datas['description'];

      $mandate->save();

      DB::table('workon')->insert(
        ['idMandate' => $mandate->id, 'idUser'  => auth()->user()->id]
        );

      return json_encode(true);
    }

    public function share($user_id,$mandate_id)
    {
        DB::table('workon')->insert(
            ['idMandate' => $mandate_id, 'idUser'  => $user_id]
        );
    }

    public function modify($mandate_id)
    {
      $mandate = Mandate::where('id',$mandate_id)->first();

      return view('mandate.modify',[
          'mandate' => $mandate,
      ]);

    }

    public function update(Request $request)
    {
      $datas = $request->all();

      $mandate = Mandate::where('id',$datas['id'])->first();
      $mandate->name = $datas['name'];
      $mandate->start = $datas['start'];
      $mandate->end = $datas['end'];
      $mandate->comment = $datas['description'];

      $mandate->save();

      return json_encode(true);
    }

    public function delete()
    {

    }

    public function getPrice()
    {
      $prices = Price::all();

      return json_encode($prices);
    }

    public function createPrice()
    {

    }

    public function editPrice($price_id)
    {

    }

    public function addWorktime($user_id,$mandate_id,$price_id)
    {

    }
}
