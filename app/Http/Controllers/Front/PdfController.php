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
use App\Http\Services\CertificateService;
use App\Http\Services\CourseCategoryService;
use App\Http\Services\CourseService;
use App\Http\Services\GalleryService;
use App\Http\Services\LangService;
use App\Http\Services\LessonService;
use App\Http\Services\LevelService;
use App\Http\Services\MailchimpService;
use App\Http\Services\MenuItemService;
use App\Http\Services\PartnerService;
use App\Http\Services\ProfileService;
use App\Http\Services\ReviewService;
use App\Http\Services\UserFinishedCourseService;
use App\Http\Services\UserService;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Partner;
use App\Models\Review;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;


class PdfController extends Controller
{

    public function create($course_slug)
    {
        $userId = auth()->user()->id;

        $user = UserService::getOne($userId);
        $course = CourseService::getOneBySlug($course_slug);


        $savePdfPath = CertificateService::generatePdf($user,$course);

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($savePdfPath, 'certificate_'.$userId."_".$course->id.".pdf", $headers);

    }


}
