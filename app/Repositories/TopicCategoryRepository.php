<?php

namespace App\Repositories;

use App\Models\TopicCategory;
use App\Traits\DbModel;
use Illuminate\Support\Collection;

class TopicCategoryRepository
{
    use DbModel;

    public function __construct(TopicCategory $model)
    {
        $this->model = $model;
    }

    /**
     * getList
     * @param  array  $search
     * @return Collection
     */
    public function getList(array $search): Collection
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

    /**
     * create
     * @param  array  $data
     * @return TopicCategory
     */
    public function create(array $data): TopicCategory
    {
        $checkFields = [
            'name',
            'is_online',
            'sort',
        ];

        return $this->checkAndCreate($data, $checkFields);
    }

    /**
     * update
     * @param  TopicCategory $dbobj
     * @param  array         $data
     */
    public function update(TopicCategory $dbobj, array $data)
    {
        $checkFields = [
            'name',
            'is_online',
            'sort',
        ];

        $this->checkAndSave($dbobj, $data, $checkFields);
    }
}
