<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mandate;use App\Workon;

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
        $mandate = Mandate::where('id',"=",$mandate_id)->get();

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

    public function edit()
    {

    }

    public function delete()
    {

    }
}
