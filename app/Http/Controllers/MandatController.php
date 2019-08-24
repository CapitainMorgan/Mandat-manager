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

    public function getAllMandate()
    {
      $mandate = Mandate::join('workon','id','=','workon.idMandate')->where("workon.idUser","=",auth()->user()->id)->get();
      
      return json_encode($mandate);
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

    public function deleteMandate($mandate_id){      
        
      Workon::where('idMandate',"=",$mandate_id)->delete();    
     
      return json_encode(true);
    }

    public function getAllUsersNotShared($mandate_id)
    {
        $usersNotChecked = DB::table('users')->where('id',"!=",auth()->user()->id)->get();
        $users = [];
        for($i = 0;$i < count($usersNotChecked);$i++)
        {
          $check = DB::table('workon')->where('idUser',"=",$usersNotChecked[$i]->id)->where('idMandate',"=",$mandate_id)->get();
          if(count($check) == 0)
          {
            $users[] = $usersNotChecked[$i];
          }
        }

        if(count($users) == 0)
        {
          $users[] = array('name' => 'Le mandat est déjà partagé pour tous les utilisateurs');
        }
        
        return json_encode($users);
    }

    public function store(Request $request)
    {
      $datas = $request->all();

      $mandate = new Mandate;
      $mandate->name = $datas['name'];
      $mandate->start = $datas['start'];
      $mandate->end = $datas['end'];
      $mandate->color = $datas['color'];
      $mandate->comment = $datas['description'];

      $mandate->save();

      DB::table('workon')->insert(
        ['idMandate' => $mandate->id, 'idUser'  => auth()->user()->id]
        );

      return json_encode(true);
    }

    public function share($mandate_id,$user_id)
    {
        DB::table('workon')->insert(
            ['idMandate' => $mandate_id, 'idUser' => $user_id]
        );

        return "true";
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

    public function getPrice()
    {
      $prices = Price::all();

      return json_encode($prices);
    }

    public function createPrice(Request $request)
    {
      $datas = $request->all();

      $price_d = $datas['price'];

      $price = new Price;
      $price->price = $price_d['price'];
      $price->name = $price_d['name'];

      $price->save();

      return json_encode(true);
    }

    public function editPrice(Request $request)
    {
      $datas = $request->all();

      $price = Price::where('id',$datas['id'])->first();
      $price->price = $datas['price'];
      $price->name = $datas['name'];

      $price->save();

      return json_encode(true);
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
          $fees->feesComment = $worktime_d['fees'][$i]['name'];
          $fees->save();
        }
    }
  }

      public function getWorkTime($id)
      {
        $worktime = WorkTime::leftjoin('fees','worktime.id','=','fees.idWorktime')->where('worktime.idMandate',$id)->get();

        return json_encode($worktime);
      }


      public function getFees($worktime_id)
      {
        $fees = Fees::where('idWorktime',$worktime_id)->get();

        return json_encode($fees);
      }

      public function editFees(Request $request)
      {
        $fees = Fees::where('id',$datas['id'])->first();
        $fees->price = $datas['price'];
        $fees->comment = $datas['comment'];

        $fees->save();

        return json_encode(true);
      }

      public function deleteFees($fees_id)
      {
        $fees = Fees::where('id',$fees_id)->first();

        $fees->delete();

        return json_encode(true);
      }

      public function deleteWorktime($id)
      {
        $fees = Fees::where('idWorktime',$id)->get();

        for($i = 0;$i < count($fees);$i++)
        {
          deleteFees($fees[$i]['id']);
        }

        $worktime = WorkTime::where('id', $id)->first();

        $worktime->delete();

        return json_encode(true);
      }

}
