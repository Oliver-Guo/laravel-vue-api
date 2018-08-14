<?php

namespace App\Repositories;

use App\Models\TopicCategory;
use App\Traits\DbModel;

class TopicCategoryRepository
{
    use DbModel;

    public function __construct(TopicCategory $model)
    {
        $this->model = $model;
    }

    public function getList($search)
    {
        return $this->model
            ->select('id', 'name', 'sort', 'is_online')
            ->where(function ($query) use ($search) {
                if (!empty($search['is_online'])) {
                    $query->where('is_online', 1);
                }
            })
            ->orderBy('sort', 'asc')
            ->get();
    }

    public function create($data)
    {
        $checkFields = [
            'name',
            'is_online',
            'sort',
        ];

        return $this->checkAndCreate($data, $checkFields);
    }

    public function update($id, $data)
    {
        $checkFields = [
            'name',
            'is_online',
            'sort',
        ];

        $this->checkAndUpdate($id, $data, $checkFields);

        return;
    }
}
