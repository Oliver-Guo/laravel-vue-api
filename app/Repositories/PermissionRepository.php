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
}
