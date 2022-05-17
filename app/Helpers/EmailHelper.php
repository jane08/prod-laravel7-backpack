<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

class EmailHelper
{
    public static function sendEmail($data,$email,$path='emails.mail',$subject="Reset Password",$file=null)
    {

        if(!empty($email)) {

            try {
                Mail::send($path, $data, function ($message) use ($email, $subject,$file) {
                    $message->to($email)
                        ->subject($subject);
                    $message->from(CommonHelper::SENDER_EMAIL, 'Temp App');
                    if(!empty($file)) {
                        $message->attach($file);
                    }
                });
            }
            catch(\Exception $e){

            }
        }
    }

}
