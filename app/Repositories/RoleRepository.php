<?php

namespace App\Repositories;

use App\Models\Role;
use App\Traits\DbModel;

class RoleRepository
{
    use DbModel;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function getList()
    {
        $result = $this->model
            ->get();

        return $result;
    }

    public function create($data)
    {
        $checkFields = array(
            'display_name',
            'name',
        );

        $createData = $this->checkAndCreate($data, $checkFields, true);

        return $createData;
    }

    public function update($id, $data)
    {
        $checkFields = array(
            'display_name',
            'name',
        );

        $this->checkAndUpdate($id, $data, $checkFields, true);

        return;
    }

    public function checkNoUnique($name)
    {
        return $this->model->where('name', $name)->count();
    }

}
