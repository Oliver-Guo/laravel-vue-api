<?php

namespace App\Http\Controllers\Api\Admin\Article;

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

    public function checkArticle($keyword)
    {

        $Article = $this->articleRepository->getCheck($keyword);

        return $this->response->array($Article);
    }
}
