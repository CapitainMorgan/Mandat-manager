<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mandate;

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

    }

    public function edit()
    {

    }
    
    public function delete()
    {

    }
}
