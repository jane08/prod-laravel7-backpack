<?php

namespace App\Http\Resources;

use App\Http\Services\NewsService;
use App\Http\Services\UserPaidCourseService;
use App\Http\Services\UserService;
use App\Models\Article;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            //'id' => $this->id,

        ];
    }
}
