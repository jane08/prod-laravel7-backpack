<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;

class RightService
{
   const ADMIN = 'admin';
   const TEACHER = 'teacher';

   public static function canWorkWithLesson($lessonId,$lessonIds)
   {
       if (in_array($lessonId, $lessonIds))
       {
           return true;
       }
       return false;
   }
}
