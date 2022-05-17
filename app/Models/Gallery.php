<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    const LIMIT = 1000;

    const LATEST = 'latest';
    const OLDEST = 'oldest';

    protected $table = 'galleries';

    protected $fillable = ['image','active','sort','link','alt'];

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
}
