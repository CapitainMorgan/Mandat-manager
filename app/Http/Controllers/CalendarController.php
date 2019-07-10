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
            '2019-07-01T0900', //END TIME
            0//Event id
        );

        $events[] = \Calendar::event(
            "Finir ", //event title
            false, //full day event
            '2019-07-03T0815', //START TIME
            '2019-07-03T0930', //END TIME
            1,//Event id
            [
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'url' => '#',
                'description' => "Event Description",
                'textColor' => '#0A0A0A'
            ]
        );

        $events[] = \Calendar::event(
            "Evenement 1", //event title
            false, //full day event
            '2019-07-03T0800', //START TIME
            '2019-07-03T1200', //END TIME
            2,//Event id
            [
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
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
