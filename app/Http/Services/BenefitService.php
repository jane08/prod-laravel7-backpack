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

class BenefitService
{
    public static function getAll($sort = 'oldest',$limit = Benefit::LIMIT)
    {
            return Benefit::published()->bysort($sort)->paginate($limit);

    }

    public static function getOne($id)
    {
        return Benefit::where(['id' => $id])->get()->first();
    }



}
