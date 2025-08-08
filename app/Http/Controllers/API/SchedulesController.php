<?php

namespace App\Http\Controllers\API;

use DateTime;
use DateInterval;
use App\ContactsSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SchedulesController extends Controller
{
    public function index(){
        $schedules=ContactsSchedule::where('user_id','=',/* Auth::user()->id' */'2')->get();

        $array = [];

        foreach ($schedules as $schedule) {
            $date = new DateTime($schedule->date_to_contact . " " . $schedule->time_to_contact);
            $date = $date->format('Y-m-d H:i:s');

            $dateEnd = new DateTime($schedule->date_to_contact . " " . $schedule->time_to_contact);
            $dateEnd = $dateEnd->add(new DateInterval('PT20M'));
            $dateEnd = $dateEnd->format('Y-m-d H:i:s');

            $array[] = [
                "start" => $date,
                "end" => $dateEnd
            ];
        }


        return $array;
    }
}
