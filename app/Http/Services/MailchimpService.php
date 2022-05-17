<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Article;
use App\Models\Benefit;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Notification;
use App\Models\StaticTrans;
use App\Models\Test;
use App\Models\UserFinishedCourse;
use App\Models\UserTest;
use Carbon\Carbon;
use Symfony\Component\Console\Helper\Helper;

class MailchimpService
{
    const LISTID = '';
    public static function addMember($email,$listId)
    {
        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => config("services.mailchimp.key"),
            'server' => 'us19'
        ]);

       /* $response = $mailchimp->lists->getAllLists();
        ddd($response);*/

        $response = $mailchimp->lists->addListMember($listId, [
            "email_address" => $email,
            "status" => "subscribed",
        ]);

    }


}
