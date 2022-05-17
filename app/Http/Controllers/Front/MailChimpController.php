<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Http\Resources\BenefitResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\ReviewResource;
use App\Http\Services\BenefitService;
use App\Http\Services\CourseCategoryService;
use App\Http\Services\CourseService;
use App\Http\Services\GalleryService;
use App\Http\Services\LangService;
use App\Http\Services\LessonService;
use App\Http\Services\LevelService;
use App\Http\Services\MailchimpService;
use App\Http\Services\MenuItemService;
use App\Http\Services\PartnerService;
use App\Http\Services\ReviewService;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\Review;
use Illuminate\Http\Request;


class MailChimpController extends Controller
{

    public $mailchimp;

    public function subscribe(SubscribeRequest $request)
    {

        try {
            MailchimpService::addMember($request['email'],MailchimpService::LISTID);
            $mess = "You successfully subscribed";
            return response()->json([
                'status'=> CommonHelper::ONE,
                "mess"=>$mess

            ], 200);

        } catch (\Exception $e) {
            $mess = "You are already subscribed";
            return response()->json([
                'status'=> CommonHelper::ZERO,
                "mess"=>$mess

            ], 200);
        }
    }


}
