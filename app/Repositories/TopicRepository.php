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

    /**
     * getList description
     * @param  array  $search
     * @return array
     */
    public function getList(array $search): array
    {
        $paginate = (!empty($search['paginate']) && (int) $search['paginate'] > 0) ? $search['paginate'] : 20;

        $data = $this->model
            ->select('*')
            ->where(function ($query) use ($search) {
                if (!empty($search['keyword'])) {
                    $query->where('title', 'like', '%' . $search['keyword'] . '%');
                }
            })
            ->with(['photo' => function ($query) {
                $query->selectRaw('imageable_id,CONCAT(path,name) name');
            }])
            ->with(['author' => function ($query) {
                $query->selectRaw('id,name');
            }])
            ->with(['topicCategory' => function ($query) {
                $query->select('id', 'name');
            }])
            ->with(['tags' => function ($query) {
                $query->select('id', 'name');
            }])
            ->paginate($paginate);

        return [
            'data'         => $data->items(),
            'current_page' => $data->currentPage(),
            'per_page'     => $data->perPage(),
            'total'        => $data->total(),
        ];
    }

    /**
     * getShow
     * @param  int    $id
     * @return Topic
     */
    public function getShow(int $id): Topic
    {
        return $this->model
            ->where('id', $id)
            ->with(['photo' => function ($query) {
                $query->selectRaw('imageable_id,CONCAT(path,name) name');
            }])
            ->with(['articles' => function ($query) {
                $query->selectRaw('id,title')
                    ->orderBy('article_topic.sort', 'asc');
            }])
            ->with(['tags' => function ($query) {
                $query->selectRaw('id,name');
            }])
            ->first();
    }

    /**
     * create
     * @param  array  $data
     * @return Topic
     */
    public function create(array $data): Topic
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

    /**
     * update
     * @param  Topic  $dbobj
     * @param  array  $data
     */
    public function update(Topic $dbobj, array $data)
    {
        $checkFields = [
            'topic_category_id',
            'author_id',
            'title',
            'description',
            'is_online',
        ];

        $this->checkAndSave($dbobj, $data, $checkFields);
    }
}
