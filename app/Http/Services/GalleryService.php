<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Article;
use App\Models\Benefit;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Gallery;
use App\Models\Notification;
use App\Models\Partner;
use App\Models\StaticTrans;
use App\Models\Test;
use App\Models\UserFinishedCourse;
use App\Models\UserTest;
use Carbon\Carbon;
use Symfony\Component\Console\Helper\Helper;

class GalleryService
{
    public static function getAll($sort = 'oldest',$limit = Gallery::LIMIT)
    {
            return Gallery::published()->bysort($sort)->paginate($limit);

    }

    public static function getOne($id)
    {
        return Gallery::where(['id' => $id])->get()->first();
    }



}
