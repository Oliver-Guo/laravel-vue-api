<?php

namespace App\Repositories;

use App\Models\PermissionGroup;
use App\Traits\DbModel;

class PermissionGroupRepository
{
    use DbModel;

    public function __construct(PermissionGroup $model)
    {
        $this->model = $model;
    }

    public function getList()
    {
        return $this->model
            ->orderBy('sort', 'asc')
            ->get();
    }

}
