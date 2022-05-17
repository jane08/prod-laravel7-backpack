<?php

namespace App\Http\Controllers\Front;

use App\Helpers\CommonHelper;
use App\Helpers\EmailHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeworkRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\UserReviewRequest;
use App\Http\Resources\BenefitResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\ReviewResource;
use App\Http\Services\_CountryService;
use App\Http\Services\BenefitService;
use App\Http\Services\CertificateService;
use App\Http\Services\CourseService;
use App\Http\Services\GalleryService;
use App\Http\Services\LessonService;
use App\Http\Services\MenuItemService;
use App\Http\Services\PartnerService;
use App\Http\Services\ProfileService;
use App\Http\Services\ReviewService;
use App\Http\Services\TransactionService;
use App\Http\Services\UserFinishedCourseService;
use App\Http\Services\UserHomeworkChatService;
use App\Http\Services\UserHomeworkService;
use App\Http\Services\UserService;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Profile;
use App\Models\Review;
use App\Models\UserFinishedCourse;
use App\Models\UserHomework;
use App\Models\UserHomeworkChat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function dashboard()
    {

        $userId = auth()->user()->id;
        // Active Courses
        // Get all bought user courses ids
        $courseIds = CourseService::getBoughtCoursesIds($userId);
        // Get all bought courses
        $activeCourses = CourseService::getCoursesByIds($courseIds);

        // Get Finished Courses
        $courseIds = UserFinishedCourseService::getFinishedCoursesIds($userId);
        $finishedCourses = CourseService::getCoursesByIds($courseIds);
        $finishedCoursesIds = CourseService::getCoursesIdsByIds($courseIds);

        $notBoughtCourses = CourseService::getNotBoughtCoursesIds($userId);


        //get courses in progress
        $courseIds = CourseService::getCoursesIdsWithHomework($userId);
        $inProgressCourses = CourseService::getCoursesInProgressByIds($courseIds, $finishedCoursesIds);


        return view('users.dashboard', [
            "activeCourses" => $activeCourses,
            "userId" => $userId,
            "finishedCourses" => $finishedCourses,
            "notBoughtCourses" => $notBoughtCourses,
            "inProgressCourses" => $inProgressCourses,

        ]);
    }

    public function myCourses()
    {
        $userId = auth()->user()->id;
        // Active Courses
        // Get all bought user courses ids
        $courseIds = CourseService::getBoughtCoursesIds($userId);
        // Get all bought courses
        $activeCourses = CourseService::getCoursesByIds($courseIds);

        return view('users.my_courses', [
            "activeCourses" => $activeCourses,
            "userId" => $userId,

        ]);
    }


    public function profile()
    {
        $countries = _CountryService::getAllArray();
        if (!empty(auth()->user()->id)) {
            $user = UserService::getOne(auth()->user()->id);
            if (!empty($user)) {
                $profile = ProfileService::getOneByUserId($user->id);
            }
        }

        if (empty($user) || empty($profile)) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.profile', [
            "countries" => $countries,
            "user" => $user,
            "profile" => $profile,

        ]);
    }

    public function updateProfile(ProfileRequest $request)
    {

        $user = UserService::getOne($request['id']);

        if (!empty($user)) {

            $profile = ProfileService::getOneByUserId($user->id);

            $profile->first_name = $request['first_name'];
            $profile->last_name = $request['last_name'];

            $profile->city = $request['city'];
            $profile->country = $request['country'];
            $profile->address = $request['address'];
            $profile->instagram = $request['instagram'];

            if (!empty($request['current_password'])) {
                $user->password = Hash::make($request['password']);
            }

            if (!empty($request->file('avatar'))) {
                $imageName = time() . '.' . request()->avatar->getClientOriginalExtension();
                $request->avatar = $imageName;
                request()->avatar->move(public_path('uploads/profiles/' . $user->id . "/"), $imageName);

                $path = "uploads/profiles/" . $user->id . "/" . $imageName;
                $profile->avatar = $path;
            }

            $user->email = $request['email'];
            $user->phone = $request['phone'];
            $user->save();
            if ($profile->save()) {
                return redirect()->back()->with('message', 'Data is saved');
            }
        }
        return redirect(route("profile"))->withErrors([
            "email" => "Data was not saved"
        ]);
    }

    public function removeAvatar(Request $request)
    {

        if (!empty($request->user_id)) {
            $user = UserService::getOne($request->user_id);

            $profile = ProfileService::getOneByUserId($user->id);

            if (\File::exists(public_path($profile->avatar))) {
                \File::delete(public_path($profile->avatar));
            }

            if (!empty($profile)) {
                $profile->avatar = null;
                $profile->save();
            }

            return response()->json([
                'html' => view('users.ajax._avatar', [
                    "user" => $user,

                ])->render(),

            ], 200);
        }
    }


    public function lesson($slug)
    {
        $userId = auth()->user()->id;
        $lesson = LessonService::getOneBySlug($slug);

        if (empty($lesson)) {
            return response()->view('errors.404', [], 404);
        }

        $course = CourseService::getOne($lesson->course_id);

        if (empty($course)) {
            return response()->view('errors.404', [], 404);
        }

        if(empty( TransactionService::getTimeLeft($userId,$course->id)))
        {
            return response()->view('errors.403', [], 403);
        }

        $lessons = LessonService::getAllByCourse($course->id);

        $lessonNext = LessonService::getNextLesson($lesson->number, $course->id);
        $lessonPrevious = LessonService::getPreviousLesson($lesson->number, $course->id);


        if (empty($lesson->homework_status)) {
            UserHomeworkService::saveUserHomework($userId, $course->id, $lesson->id, UserHomework::STATUS_SUCCESS, UserHomework::OPENED);
            $finished = CourseService::checkIfCourseFinished($course->id, $userId);
            CourseService::finishCourse($course->id, $userId, $finished);
        }

        $userHomeworkChats = UserHomeworkChatService::getAllByUserLesson($userId, $lesson->id);
        $finishedCourse = UserFinishedCourseService::getOneByUserCourse($userId, $course->id);
        $userHomework = UserHomeworkService::getOneByUserLesson($userId, $lesson->id);
        $canWatchLesson = \App\Http\Services\LessonService::canWatchLesson($lesson, $course, $userId);
        if (empty($canWatchLesson)) {
            return response()->view('errors.404', [], 404);
        }
        return view('users.lessons', [
            "userId" => $userId,
            "lesson" => $lesson,
            "lessons" => $lessons,
            "course" => $course,
            "lessonNext" => $lessonNext,
            "lessonPrevious" => $lessonPrevious,
            "userHomeworkChats" => $userHomeworkChats,
            "finishedCourse" => $finishedCourse,
            "userHomework" => $userHomework,
            "canWatchLesson" => $canWatchLesson,

        ]);
    }

    public function saveHomework(HomeworkRequest $request)
    {
        $userId = auth()->user()->id;
        $userHomework = UserHomeworkService::saveUserHomework($userId, $request['course_id'], $request['lesson_id'], UserHomework::STATUS_IN_PROGRESS);

        $userHomeworkChat = UserHomeworkService::saveUserHomeworkChat($userId, $request['course_id'], $request['lesson_id'], null, $request['message'], $request);

        $finished = CourseService::checkIfCourseFinished($request['course_id'], $userId);
        CourseService::finishCourse($request['course_id'], $userId, $finished);

        return redirect()->back()->with('message', 'Data is saved');
    }


    public function review($course_slug)
    {
        $userId = auth()->user()->id;

        $course = CourseService::getOneBySlug($course_slug);
        if (empty($course)) {
            return response()->view('errors.404', [], 404);
        }

        if(empty( TransactionService::getTimeLeft($userId,$course->id)))
        {
            return response()->view('errors.403', [], 403);
        }

        $lessons = LessonService::getAllByCourse($course->id);

        return view('users.review', [
            "userId" => $userId,

            "lessons" => $lessons,
            "course" => $course,
        ]);
    }

    public function addReview(UserReviewRequest $request)
    {
        $userId = auth()->user()->id;
        $user = UserService::getOne($userId);
        $review = Review::where(["user_id"=>$userId,"course_id"=>$request['course_id']])->first();
        $course = CourseService::getOne($request['course_id']);

        if(empty($review))
        {
            $review = new Review();
            $review->user_id = $userId;
            $review->course_id = $request['course_id'];
            $review->content = $request['content'];
            $review->name = $request['name'];
            $review->rating = $request['rating'];
            $review->published_date =  Carbon::now()->toDateTimeString();
            $review->main_page =  CommonHelper::ZERO;
            if($review->save()){

                $data = ['course' => $course,"user"=>$user];
                $file = CertificateService::generatePdf($user,$course);

                EmailHelper::sendEmail($data, $user->email, 'emails.course_finish',"Course Completed",$file);


                return redirect(route("review-thankyou",["course_slug"=>$course->slug]));
            }
        }
    }

    public function reviewThankyou($course_slug)
    {
        $userId = auth()->user()->id;

        $course = CourseService::getOneBySlug($course_slug);
        if (empty($course)) {
            return response()->view('errors.404', [], 404);
        }
        $review = Review::where(["user_id"=>$userId,"course_id"=>$course->id])->first();
        if (empty($review)) {
            return response()->view('errors.404', [], 404);
        }
        $lessons = LessonService::getAllByCourse($course->id);
        return view('users.review_thankyou', [
            "userId" => $userId,

            "lessons" => $lessons,
            "course" => $course,
            "review" => $review,
        ]);
    }

}
