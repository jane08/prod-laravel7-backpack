<?php

namespace App\Http\Resources;

use App\Helpers\CommonHelper;
use App\Http\Services\NewsService;
use App\Http\Services\UserPaidCourseService;
use App\Http\Services\UserService;
use App\Models\Article;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        $lessonsQty = Lesson::published()->where(["course_id"=>$this->id])->count()??CommonHelper::ZERO;

        return [
            'id' => $this->id,
            'categories' => CourseCategoryResource::collection( ($this->categories)),
            'title' => $this->title,
            'slug' => $this->slug,
            'preview_text' => $this->preview_text,
            'description' => $this->description,
            'active' => $this->active,
            'paid' => $this->paid,
            'scores' => $this->scores,
            'price' => $this->price,
            'hours' => $this->hours,
            'lesson_qty' => $lessonsQty,
            'speakers' => $this->speakers,
            'first' => $this->first,
            'youtube' => $this->youtube,
            'preview_image' => $this->preview_image,
            'image' => $this->image,
            'access_hours' => $this->access_hours,
            'course_is_for_you' => $this->course_is_for_you,
            'program_id' => $this->program_id,
            'lang' => $this->lang,
            'level' => $this->level,
            'registered_students' => $this->registered_students,


        ];
    }
}
