<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\DbModel;

class UserRepository
{
    use DbModel;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function update($id, $data)
    {
        $checkFields = array(
            'name',
            'password',
        );

        $this->checkAndUpdate($id, $data, $checkFields);

        return;
    }

    public function softdel($id)
    {
        $this->updateOneField($id, 'deleted_at', time());

        return;
    }

    public function getList(array $search)
    {
        $paginate = (!empty($search['paginate']) && (int) $search['paginate'] > 0) ? $search['paginate'] : 20;

        $result = $this->model
            ->select('id', 'name', 'email')
            ->where(function ($query) use ($search) {
                if (!empty($search['keyword'])) {
                    $query->where('name', 'like', '%' . $search['keyword'] . '%');
                }
            })
            ->paginate($paginate);

        return $result;
    }
}
