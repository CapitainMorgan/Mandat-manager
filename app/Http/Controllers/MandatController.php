<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mandate;
use App\Workon;
use App\Price;
use App\Fees;
use App\WorkTime;

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

    public function addWorktime(Request $request)
    {
      $datas = $request->all();

      $worktime = new WorkTime();

      $worktime_d = $datas['worktime'];

      $fees = [];
      $price = Price::where('id',$worktime_d['price'])->first();
      $worktime->idMandate = $datas['mandate_id'];
      $worktime->idUser = 1;
      $worktime->idPrice = $price->id;
      $worktime->start = str_replace('T', ' ',$worktime_d['start']);
      $worktime->end = str_replace('T', ' ',$worktime_d['end']);
      $worktime->comment = $worktime_d['comment'];

      $worktime->save();

      if($worktime_d['fees_number'] > 0)
      {

        for($i = 0; $i<$worktime_d['fees_number']; $i++)
        {
          $fees = new Fees();
          $fees->idWorktime = $worktime->id;
          $fees->price = $worktime_d['fees'][$i]['value'];
          $fees->comment = $worktime_d['fees'][$i]['name'];
          $fees->save();
        }
      }
    }

      public function getWorkTime($id)
      {
        $worktime = WorkTime::where('idMandate',$id)->get();

        return json_encode($worktime);
      }


      public function deleteWorktime($id)
      {
        $worktime = WorkTime::where('id', $id)->first();

        $worktime->delete();

        return json_encode(true);
      }

}
