<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendSmsUser;
use Illuminate\Http\Request;

class SendSmsController extends Controller
{
    public function sendSMS()
    {
        $user = '+573188332243';

        //  SendSmsUser::dispatch($user)->onQueue('sms');
         dispatch(new SendSmsUser($user));
            // $this->dispatch($job);
            // echo $player->mobile;
            // echo "<br/>";

    }
}
