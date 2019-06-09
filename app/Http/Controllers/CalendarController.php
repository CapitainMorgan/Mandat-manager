<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $events = [];

        $events[] = \Calendar::event(
            "Event one", //event title
            true, //full day event
            '2017-01-02T0900', //START TIME
            '2017-01-06T0800', //END TIME
            0//Event id
        );

        $calendar = \Calendar::addEvents($events)
                    ->setOptions([
                        'firstDay' => 1
        ]);


        return view('calendar', array('calendar' => $calendar));
    }
    
}
