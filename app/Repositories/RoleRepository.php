<?php

namespace App\Repositories;

use App\Models\Role;
use App\Traits\DbModel;
use Illuminate\Support\Collection;

class RoleRepository
{
    use DbModel;

    public function __construct(Role $model)
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
            ->get();

    }

    /**
     * getSelects
     * @return Collection
     */
    public function getSelects(): Collection
    {
        return $this->model
            ->select('id', 'display_name')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * create
     * @param  array  $data
     * @return Role
     */
    public function create(array $data): Role
    {
        $checkFields = [
            'display_name',
            'name',
        ];

        return $this->checkAndCreate($data, $checkFields, true);

    }

    /**
     * update
     * @param  Role   $dbobj
     * @param  array  $data
     */
    public function update(Role $dbobj, array $data)
    {
        $checkFields = [
            'display_name',
            'name',
        ];

        $this->checkAndSave($dbobj, $data, $checkFields, true);

    }

    /**
     * checkNoUnique
     * @param  string $name
     * @return int
     */
    public function checkNoUnique(string $name): int
    {
        return $this->model
            ->where('name', $name)
            ->count();
    }

}
