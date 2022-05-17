<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Article;
use App\Models\Category;
use App\Models\StaticTrans;
use Carbon\Carbon;

class NewsService
{
    public static function getAll($sort = 'oldest',$limit = Article::LIMIT)
    {
        return Article::published()->sort($sort)->beforeFuture()->paginate($limit);
    }

    public static function getOne($id)
    {
        return Article::where(['id' => $id])->get()->first();
    }

    public static function getOneBySlug($slug)
    {

        return Article::where(['slug' => $slug])->get()->first()??null;
    }

    public static function getAllBest($sort = 'latest',$limit = Article::LIMIT)
    {
        return Article::published()->where(["best"=>CommonHelper::ONE])->sort($sort)->beforeFuture()->paginate($limit);
    }

    public static function getAllByCategory($catIds, $sort = 'latest', $limit = Article::LIMIT)
    {
        if(!empty($catIds)) {
            $categories = Category::whereIn('id', $catIds)->get();
            if(!empty($categories)) {
                $articlesIds = Article::getArticlesIdsByCategories($categories);
                if (!empty($articlesIds)) {
                    return Article::published()->sort($sort)->beforeFuture()->whereIn('id', $articlesIds)->paginate($limit);
                }
            }
            else{
                return null;
            }
        }
        return null;
    }

}
