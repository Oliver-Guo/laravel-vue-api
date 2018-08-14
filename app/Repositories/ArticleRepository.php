<?php

namespace App\Repositories;

use App\Models\Article;
use App\Traits\DbModel;

class ArticleRepository
{
    use DbModel;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function getCheck($keyword)
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
