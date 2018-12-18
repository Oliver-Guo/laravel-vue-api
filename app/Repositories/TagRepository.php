<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Traits\DbModel;
use Illuminate\Support\Collection;

class TagRepository
{
    use DbModel;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    /**
     * getRsSearch
     * @param  string $name
     * @return Collection
     */
    public function getRsSearch(string $name): Collection
    {

        return $this->model
            ->select('name')
            ->where('name', 'like', '%' . $name . '%')
            ->skip(0)->take(10)
            ->get();
    }
}
