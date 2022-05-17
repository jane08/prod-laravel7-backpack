<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;

use App\Models\Review;
use App\Models\StaticTrans;


class ReviewService
{

    public static function getAll($sort = 'oldest',$limit = Review::LIMIT)
    {
        return Review::published()->bysort($sort)->paginate($limit);

    }

    public static function getAllMain($sort = 'latest',$limit = Review::LIMIT)
    {
        return Review::where(["main_page"=>CommonHelper::ONE])->published()->bysort($sort)->paginate($limit);

    }

    public static function getOne($id)
    {
        return Review::where(['id'=>$id])->get()->first();
    }

    public static function getAllByCourseId($courseId,$sort = 'oldest',$limit = Review::LIMIT)
    {
        return Review::published()->where(['course_id'=>$courseId])->bysort($sort)->paginate($limit);

    }

    public static function getOneByUserCourseId($userId,$courseId)
    {
        return Review::published()->where(['course_id'=>$courseId,"user_id"=>$userId])->first();
    }


    public static function getRating($courseId)
    {
        $rating = 0;
        $i=1;
       $reviews = Review::where(['course_id'=>$courseId])->get();
       if(($reviews->isNotEmpty()))
       {
           $i = 0;
           foreach($reviews as $review)
           {
               $rating+=$review->rating;
               $i++;
           }
       }
       return round($rating/$i, 0, PHP_ROUND_HALF_UP);
    }

    public static function getCountRating($courseId)
    {
        return  Review::where(['course_id'=>$courseId])->count();
    }

    public static function getReviewLink($userId,$courseId)
    {
        $review = Review::where(["user_id"=>$userId,"course_id"=>$courseId])->first();
        $course = CourseService::getOne($courseId);
        if(!empty($review))
        {
           return route("review-thankyou",["course_slug"=>$course->slug]);
        }
        return route("review",["course_slug"=>$course->slug]);
    }

}
