<?php

namespace App\Repositories;

use App\Models\PermissionGroup;
use App\Traits\DbModel;
use Illuminate\Support\Collection;

class PermissionGroupRepository
{
    use DbModel;

    public function __construct(PermissionGroup $model)
    {
        $this->model = $model;
    }

    /**
     * getList
     * @return Collection
     */
    public function getList(): Collection
    {
        return $this->model
            ->with(['permission' => function ($query) {
                $query->selectRaw('permissions.id ,
                                permissions.permission_group_id,
                                permissions.display_type,
                                permissions.display_name,
                                permissions.name')
                    ->orderBy('permissions.display_type', 'asc')
                    ->orderBy('permissions.sort', 'asc');
            }])
            ->orderBy('sort', 'asc')
            ->get();
    }

}
