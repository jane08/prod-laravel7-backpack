<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Helpers\ImageHelper;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use CrudTrait;

    const LIMIT = 10000;

    const LATEST = 'latest';
    const OLDEST = 'oldest';

    protected $table = 'reviews';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['name','title','alt', 'content', 'sort','image','status','rating','user_id','special_word','main_page','course_id','published_date'];


    public static $statuses = [
        'moderation' => 'Moderation',
        'published' => 'Published',
        'canceled' => 'Canceled',
    ];

    /**
     * uncomment if you need path instead of base64
     * @param $value
     */
   /* public function setImageAttribute($value)
    {
        $destination_path = "public/uploads/reviews";
        $attribute_name = 'image';

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);
    }*/

    public static function boot()
    {
        parent::boot();
        static::deleted(function($obj) {
            \Storage::disk('public')->delete($obj->image);
        });
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public static function getStatuses()
    {
        return self::$statuses;
    }

    public static function getOneStatus($key)
    {
        return self::$statuses[$key];
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function scopeSort($query,$sort)
    {
        if($sort==self::LATEST) {
            $query->orderBy('id', 'DESC');
        }
        else{
            $query->orderBy('id');
        }
    }

    public function scopeBysort($query,$sort)
    {
        if($sort==self::LATEST) {
            $query->orderBy('sort', 'DESC');
        }
        else{
            $query->orderBy('sort');
        }
    }


    public function scopePublished($query)
    {
        return $query->where('status', self::getOneStatus("published"));
    }

    public function getPublishedDateAttribute($value) {

        $value = Carbon::parse($value);

        return  $value->format('F d, Y');
    }
}
