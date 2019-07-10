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
        $mandate = Mandate::all();

        return view('mandate.mandates',[
            'mandate' => $mandate,
        ]);
    }

    public function show($n)
    {
        $quiz = current(Mandate::all()->where('id',$n)->toArray());

        return view('mandate.show',[
            'quiz' => $quiz,
            'question' => $question,
            'made' => $made,
        ]);
    }

    public function create()
    {
        return view('mandate.create',[]);
    }

    public function store()
    {
        
    }

    public function share($idUser,$idMandate)
    {
        DB::table('workon')->insert(
            ['idMandate' => $idMandate, 'idUser'  => $idUser]
        );
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
