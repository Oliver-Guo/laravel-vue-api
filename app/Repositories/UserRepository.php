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

    /**
     * getList
     * @param  array  $search
     * @return array
     */
    public function getList(array $search): array
    {
        $paginate = (!empty($search['paginate']) && (int) $search['paginate'] > 0) ? $search['paginate'] : 20;

        $data = $this->model
            ->select('id', 'name', 'email')
            ->where(function ($query) use ($search) {
                if (!empty($search['keyword'])) {
                    $query->where('name', 'like', '%' . $search['keyword'] . '%');
                }
            })
            ->paginate($paginate);

        return [
            'data'         => $data->items(),
            'current_page' => $data->currentPage(),
            'per_page'     => $data->perPage(),
            'total'        => $data->total(),
        ];

    }

    /**
     * create
     * @param  array  $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->model
            ->create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
    }

    /**
     * update
     * @param  User   $dbobj
     * @param  array  $data
     */
    public function update(User $dbobj, array $data)
    {
        $checkFields = array(
            'name',
            'password',
        );

        $this->checkAndSave($dbobj, $data, $checkFields);
    }

    /**
     * softdel
     * @param  int    $id
     */
    public function softdel(int $id)
    {
        $this->updateOneField($id, 'deleted_at', time());
    }

}
