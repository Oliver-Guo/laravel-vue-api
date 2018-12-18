<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Controller;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller
{
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        parent::__construct();
        $this->articleRepository = $articleRepository;
    }

    public function rsSearch($keyword)
    {
        $article = $this->articleRepository->getRsSearch($keyword);

        return $this->response->array($article);
    }
}
