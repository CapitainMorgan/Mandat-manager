<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\WorkTime;

class CalendarController extends Controller
{
    /**
 * Show the application dashboard.
 *
 * @return \Illuminate\Contracts\Support\Renderable
 */
    public function index()
    {
        return view('calendar');
    }

    public function events()
    {
        //https://github.com/maddhatter/laravel-fullcalendar

        $worktimes = DB::table('worktime')->where('idUser',auth()->user()->id)->get();        
                
        $events = [];

        foreach($worktimes as $worktime)
        {
            $mandate = DB::table('mandate')->join('worktime',"mandate.id","=","worktime.idMandate")->where('worktime.id',$worktime->id)->get();
            
            $events[] = array(
                "title" => $mandate[0]->name." / ".$worktime->comment, //event title
                "start" => \Carbon\Carbon::parse($worktime->start)->format("Y-m-d H:i:00"), //START TIME
                "end" => \Carbon\Carbon::parse($worktime->end)->format("Y-m-d H:i:00"), //END TIME   
                "color" => $mandate[0]->color,            
            );
        }        

        return response()->json(['events' => $events]);
    }
}
