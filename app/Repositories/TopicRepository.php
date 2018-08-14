<?php

namespace App\Repositories;

use App\Models\Topic;
use App\Traits\DbModel;

class TopicRepository
{
    use DbModel;

    public function __construct(Topic $model)
    {
        $this->model = $model;
    }

    public function getList(array $search)
    {
        $paginate = (!empty($search['paginate']) && (int) $search['paginate'] > 0) ? $search['paginate'] : 20;

        return $this->model
            ->select('*')
            ->where(function ($query) use ($search) {
                if (!empty($search['keyword'])) {
                    $query->where('title', 'like', '%' . $search['keyword'] . '%');
                }
            })
            ->paginate($paginate);
    }

    public function create($data)
    {
        $checkFields = [
            'topic_category_id',
            'author_id',
            'title',
            'description',
            'is_online',
        ];

        return $this->checkAndCreate($data, $checkFields);
    }

    public function update($id, $data)
    {
        $checkFields = [
            'topic_category_id',
            'author_id',
            'title',
            'description',
            'is_online',
        ];

        $this->checkAndUpdate($id, $data, $checkFields);

        return;
    }

}
