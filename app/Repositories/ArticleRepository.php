<?php

namespace App\Repositories;

use App\Models\Article;
use App\Traits\DbModel;
use Illuminate\Support\Collection;

class ArticleRepository
{
    use DbModel;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    /**
     * getRsSearch
     * @param  string $keyword
     * @return Collection
     */
    public function getRsSearch(string $keyword): Collection
    {
        return $this->model
            ->select('id', 'title')
            ->where(function ($query) use ($keyword) {
                $query->orwhere('id', $keyword)
                    ->orWhere('title', 'like', '%' . $keyword . '%');
            })
            ->skip(0)->take(10)
            ->get();
    }
}
