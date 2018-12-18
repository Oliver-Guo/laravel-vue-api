<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Traits\DbModel;

class PermissionRepository
{
    use DbModel;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model
            ->select('name')
            ->orderBy('name', 'ASC')
            ->get()
            ->pluck('name');
    }
}
