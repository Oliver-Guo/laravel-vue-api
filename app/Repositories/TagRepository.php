<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Traits\DbModel;

class TagRepository
{
    use DbModel;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function getCheck($name)
    {

        return $this->model
            ->select('name')
            ->where('name', 'like', '%' . $name . '%')
            ->skip(0)->take(10)
            ->get();
    }
}
