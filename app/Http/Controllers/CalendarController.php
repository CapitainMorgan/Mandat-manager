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
            "Finir le projet", //event title
            false, //full day event
            '2019-07-01T0800', //START TIME
            '2019-07-08T0900', //END TIME
            0//Event id
        );

        $events[] = \Calendar::event(
            "Finir ", //event title
            false, //full day event
            '2019-07-02T0800', //START TIME
            '2019-07-07T0900', //END TIME
            1,//Event id
            [
                'color' => '#888888',
                'url' => '#',
                'description' => "Event Description",
                'textColor' => '#0A0A0A'
            ]
        );

        $calendar = \Calendar::addEvents($events)
                    ->setOptions([
                        'firstDay' => 1
        ]);


        return view('calendar', array('calendar' => $calendar));
    }
    
}
