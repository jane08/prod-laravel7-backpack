<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Helpers\ImageHelper;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslations;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;
    use HasTranslations;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const LIMIT = 12;
    const MAIN_LIMIT = 3;
    const BEST_LIMIT = 3;
    const TYPE_BEST = 'best';
    const TYPE_MAIN = 'main';
    const LATEST = 'latest';
    const OLDEST = 'oldest';

    protected $table = 'articles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['slug', 'title', 'content', 'image', 'status', 'category_id','active', 'featured', 'date','preview','best','source','source_link'];
    // protected $hidden = [];
    // protected $dates = [];

    protected $translatable = ['title', 'content','source'];

    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'article_tag');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'article_category');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED')
            ->where('date', '<=', date('Y-m-d'))
            ->orderBy('date', 'DESC');
    }*/

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public static function getArticlesIdsByCategories($categories)
    {
        $articlesIds = [];
        if (!empty($categories)) {
            foreach ($categories as $category) {
                if (!empty($category->articles)) {
                    foreach ($category->articles as $article) {
                        $articlesIds[$article->id] = $article->id;
                    }
                }
            }
        }
        return $articlesIds;
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }


    /**
     * Saving images as path
     * uncomment if you need path instead of base64
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $destination_path = "public/uploads/news";
        $attribute_name = 'image';

        $url = parse_url($value);
        if(!empty($url['host']))
        {
            $value = $url['path'];
        }

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);

    }

    public function setPreviewAttribute($value)
    {
        $destination_path = "public/uploads/news";
        $attribute_name = 'preview';

        $url = parse_url($value);
        if(!empty($url['host']))
        {
            $value = $url['path'];
        }

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);

    }

    /*
   |--------------------------------------------------------------------------
   | scopes
   |--------------------------------------------------------------------------
   */

    public function scopeSort($query,$sort)
    {
        if($sort==self::LATEST) {
            $query->orderBy('date', 'DESC');
        }
        else{
            $query->orderBy('date');
        }
    }

    public function scopePublished($query)
    {
        return $query->where('active', CommonHelper::ACTIVE);
    }

    public function scopeBeforeFuture($query)
    {
        return $query->whereDate('date', '<=', Carbon::now());
    }
}
