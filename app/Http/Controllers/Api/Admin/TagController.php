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

    public function checkTag($name)
    {

        $tag = $this->tagRepository->getCheck($name);

        return $this->response->array($tag);
    }
}
