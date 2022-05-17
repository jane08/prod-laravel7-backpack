<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use CrudTrait;

    const LIMIT = 1000;

    const LATEST = 'latest';
    const OLDEST = 'oldest';
    const TOP = 'top';
    const FOOTER_LINKS = 'footer_links';
    const FOOTER_INFO = 'footer_info';
    const PAGE = 'page';

    const TYPE_INTERNAL = 'internal_link';
    const TYPE_EXTERNAL = 'external_link';
    const TYPE_PAGE = 'page_link';

    const PAGE_MAIN = 'main';
    const PAGE_COURSES = 'courses';
    const PAGE_COURSE = 'course';
    const PAGE_LESSONS = 'lessons';
    const PAGE_404 = 'error_404';
    const PAGE_AUTH = 'auth';
    const PAGE_THANKYOU = 'thankyou';
    const PAGE_CHECKOUT = 'checkout';
    const PAGE_CHANGE_TARIFF = 'change_tariff';
    const PAGE_CONTACT = 'contact';
    const PAGE_REVIEW = 'review';
    const PAGE_ERRORS= 'errors';


    const TERMS_OF_SERVICE_URL = "terms";
    const PRIVACY_URL = "privacy-policy";

    public static $pages = [
        self::PAGE_MAIN => 'Main',
        self::PAGE_COURSES => 'Courses',
        self::PAGE_COURSE => 'Course',
        self::PAGE_LESSONS => 'Lessons',
        self::PAGE_404 => 'Error 404',
        self::PAGE_AUTH => 'Auth',
        self::PAGE_THANKYOU => 'Thank you',
        self::PAGE_CHECKOUT => 'Checkout',
        self::PAGE_CHANGE_TARIFF => 'Change Tariff',
        self::PAGE_CONTACT => 'Contact',
        self::PAGE_REVIEW => 'Review',
        self::PAGE_ERRORS => 'Errors',

    ];

    public static $menuPositions = [
        'top' => 'Top',
        'footer_links' => 'Footer Links',
        'footer_info' => 'Footer Info',
      //  'page' => 'Page',
    ];


    protected $table = 'menu_items';
    protected $fillable = ['name', 'type', 'link', 'page_id', 'parent_id','position','sort'];

    public function parent()
    {
        return $this->belongsTo('App\Models\MenuItem', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\MenuItem', 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id');
    }

    /**
     * Get all menu items, in a hierarchical collection.
     * Only supports 2 levels of indentation.
     */
    public static function getTree()
    {
        $menu = self::orderBy('lft')->get();

        if ($menu->count()) {
            foreach ($menu as $k => $menu_item) {
                $menu_item->children = collect([]);

                foreach ($menu as $i => $menu_subitem) {
                    if ($menu_subitem->parent_id == $menu_item->id) {
                        $menu_item->children->push($menu_subitem);

                        // remove the subitem for the first level
                        $menu = $menu->reject(function ($item) use ($menu_subitem) {
                            return $item->id == $menu_subitem->id;
                        });
                    }
                }
            }
        }

        return $menu;
    }

    public function url()
    {
        switch ($this->type) {
            case 'external_link':
                return $this->link;
                break;

            case 'internal_link':
                return is_null($this->link) ? '#' : url($this->link);
                break;

            default: //page_link
                if ($this->page) {
                    return url($this->page->slug);
                }
                break;
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


    public function getLink()
    {
        $menuLink =  url($this->link);
        if($this->type==\App\Models\MenuItem::TYPE_EXTERNAL)
        {
            $menuLink = $this->link;
        }
        else if($this->type==\App\Models\MenuItem::TYPE_PAGE){
            $menuLink = $this->page->slug;

        }
        return $menuLink;
    }

    public static function getMenuPositions()
    {
        return self::$menuPositions;
    }
    public static function getMenuPosition($key)
    {
        return self::$menuPositions[$key];
    }

}
