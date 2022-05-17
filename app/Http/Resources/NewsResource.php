<?php

namespace App\Http\Resources;

use App\Http\Services\NewsService;
use App\Models\Article;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sort = Article::LATEST;
        $bests = NewsService::getAllBest($sort,Article::BEST_LIMIT);
        return [
            'id' => $this->id,
            'categories' => CategoryResource::collection( ($this->categories)),
            'tags' => TagResource::collection( ($this->tags)),
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'active' => $this->active,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'source' => $this->source,
            'source_link' => $this->source_link,
            'image' => env('APP_URL') .'/'.$this->image,
            'preview' => env('APP_URL') .'/'.$this->preview,
            'best' => $this->best,
            'bests' => $bests,
        ];
    }
}
