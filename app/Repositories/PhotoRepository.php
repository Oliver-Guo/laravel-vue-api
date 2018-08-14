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

    public function imageableDel($imageable_ids, $imageable_type)
    {
        $this->model
            ->whereIn('imageable_id', $imageable_ids)
            ->where('imageable_type', $imageable_type)
            ->delete();
    }

}
