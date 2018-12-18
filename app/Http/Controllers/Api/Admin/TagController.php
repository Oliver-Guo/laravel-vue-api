<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Controller;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        parent::__construct();
        $this->tagRepository = $tagRepository;
    }

    public function rsSearch($name)
    {

        $tag = $this->tagRepository->getRsSearch($name);

        return $this->response->array($tag);
    }
}
