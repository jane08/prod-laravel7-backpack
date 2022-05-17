<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Benefit extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasTranslations;

    const LIMIT = 100000;

    const LATEST = 'latest';
    const OLDEST = 'oldest';

    protected $table = 'benefits';

    protected $fillable = ['title', 'description', 'image','active','sort','alt'];
    protected $translatable = ['title', 'description'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
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
        return $query->where('active', CommonHelper::ACTIVE);
    }

  /*  public function setImageAttribute($value)
    {
        $destination_path = "public/uploads/benefits";
        $attribute_name = 'image';

        $url = parse_url($value);
        if(!empty($url['host']))
        {
            $value = $url['path'];
        }

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);

    }*/
}
