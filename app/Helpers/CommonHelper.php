<?php

namespace App\Helpers;

use App\Http\Services\UserService;
use Illuminate\Support\Str;

class CommonHelper
{
   const SORT_DEFAULT = 500;
   const ACTIVE = 1;
   const NOT_ACTIVE = 0;
   const ZERO = 0;
   const ONE = 1;
   const SENDER_EMAIL = 'test@gmail.com';
   const ADMIN_EMAIL = 'info.admin@gmail.com';
   const ADMIN_NAME = 'admin';
   const STRIPE_HUNDRED = 100;
   const HUNDRED = 100;

   public static function valSort($array,$key,$sort = CommonHelper::ACTIVE) {

       //Loop through and get the values of our specified key

       foreach($array as $k=>$v) {
               $b[$k] = ($v[$key]);
       }

       if($sort == CommonHelper::ACTIVE)
       {
           arsort($b);
       }
       else {
           asort($b);
       }

       foreach($b as $k=>$v) {
           $c[$k] = $array[$k];
       }
       return $c;
   }

   public static function replaceWord($word,$value,$text)
   {
       return str_replace($word,$value,$text);
   }

   public static function generateApiToken()
   {
       $apiToken =  hash('sha256', Str::random(60));
       $user = UserService::getOneByToken($apiToken);
       if(!empty($apiToken)) {
           return $apiToken;
       }
       return null;
   }

    public static function replaceProductText ($course,$field)
    {
        $field = str_replace([
            '{first_course}',
        ], [
            $course->title??'' ,

        ], $field);
        return $field;
    }

    public static function replaceCourseData ($course,$lesson=null,$field=null,$profile=null)
    {
        $first_name = "";
        $last_name = "";
        if(!empty($profile))
        {
            $first_name = $profile->first_name;
            $last_name =$profile->last_name;
        }

        $field = str_replace([
            '{course}',
            '{lesson}',
            '{course_point}',
            '{fio_refferal}',
        ], [
            $course->title??'' ,
            $lesson->title??'' ,
            $course->scores??'' ,
            $first_name ." ". $last_name,

        ], $field);
        return $field;
    }

    public static function getActualLink()
    {
       return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function getSiteUrl()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }

}
