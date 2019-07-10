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
        //https://github.com/maddhatter/laravel-fullcalendar

        $worktimes = DB::table('worktime')->where('idUser',auth()->user()->id)->get();
        
        $events = [];
        
        foreach($worktimes as $worktime)
        {
            $events[] = \Calendar::event(
                $worktime->comment, //event title
                false, //full day event
                \Carbon\Carbon::parse($worktime->start)->format("Y-m-dTHi"), //START TIME
                \Carbon\Carbon::parse($worktime->end)->format("Y-m-dTHi"), //END TIME
                [
                    'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                    'url' => 'mandate/'.$worktime->idMandate,
                    'textColor' => '#0A0A0A'
                ]
            );
        }        

        $calendar = \Calendar::addEvents($events)
                    ->setOptions([
                        'firstDay' => 1
        ]);


        return view('calendar', array('calendar' => $calendar));
    }

}
