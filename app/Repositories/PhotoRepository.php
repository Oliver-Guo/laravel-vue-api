<?php

namespace App\Repositories;

use App\Models\Photo;
use App\Traits\DbModel;

class PhotoRepository
{
    use DbModel;

    public function __construct(Photo $model)
    {
        $this->model = $model;
    }

    /**
     * imageableDel
     * @param  array  $imageable_ids
     * @param  string $imageable_type
     */
    public function imageableDel(array $imageable_ids, string $imageable_type)
    {
        $this->model
            ->whereIn('imageable_id', $imageable_ids)
            ->where('imageable_type', $imageable_type)
            ->delete();
    }

}
