<?php

namespace App\Http\Resources;

use App\Http\Services\StaticTransService;
use App\Http\Services\TestService;
use App\Http\Services\UserService;
use App\Models\MenuItem;
use App\Models\Test;
use App\Models\UserTest;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $token = $request->bearerToken();
        $user = null;
        if (!empty($token)) {
            $user = UserService::getOneByToken($token);
            if (!empty($user)) {
                $user = new UserResource($user);
            }
        }

        $testSlug = "";
        $testStatus = "";

        $passTestButton = null;
        $test = TestService::getOneByLesson($this->id);

        $userTest = UserTest::where(["user_id" => $user->id,"status"=>Test::STATUS_SUCCESS,"lesson_id"=>$this->id, "course_id" => $this->course_id, "opened"=>UserTest::OPENED])->first();

        if(!empty($test))
        {
            $passTestButton = StaticTransService::getListByPageKey(MenuItem::PAGE_LESSONS,'lesson_pass_test_button')->content;
            if(!empty($userTest))
            {
                $testSlug = $test->slug;
                $testStatus = $userTest->status;
            }

        }
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'preview_text' => $this->preview_text,
            'description' => $this->description,
            'active' => $this->active,
            'number' => $this->number,

            'youtube' => $this->youtube,
            'preview_image' => $this->preview_image,
            'image' => $this->image,
            'test_slug' => $testSlug,
            'test_status' => $testStatus,
            'pass_test_button' => $passTestButton,
        ];
    }
}
