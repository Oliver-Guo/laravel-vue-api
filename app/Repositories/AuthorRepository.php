<?php

namespace App\Repositories;

use App\Models\Author;
use App\Traits\DbModel;
use Illuminate\Support\Collection;

class AuthorRepository
{
    use DbModel;

    public function __construct(Author $model)
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
        $paginate = (!empty($search['paginate']) && (int) $search['paginate'] > 0) ? $search['paginate'] : 10;

        $data = $this->model
            ->select('id', 'name', 'is_online')
            ->where(function ($query) use ($search) {
                if (!empty($search['keyword'])) {
                    $query->where('name', 'like', '%' . $search['keyword'] . '%');
                }
            })
            ->with(['photo' => function ($query) {
                $query->selectRaw('imageable_id,CONCAT(path,name) name');
            }])
            ->orderBy('id', 'asc')
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
     * @return Author
     */
    public function getShow(int $id): Author
    {
        return $this->model
            ->where('id', $id)
            ->with(['photo' => function ($query) {
                $query->selectRaw('imageable_id,CONCAT(path,name) name');
            }])
            ->first();
    }

    /**
     * getSelects
     * @return Collection
     */
    public function getSelects(): Collection
    {
        return $this->model
            ->select('id', 'name')
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * create
     * @param  array  $data
     * @return Author
     */
    public function create(array $data): Author
    {
        $checkFields = [
            'name',
            'description',
            'outsite_url',
            'fb_share',
            'google_share',
            'twitter_share',
            'is_online',
        ];

        return $this->checkAndCreate($data, $checkFields);
    }

    /**
     * update
     * @param  Author $dbobj
     * @param  array  $data
     */
    public function update(Author $dbobj, array $data)
    {
        $checkFields = [
            'name',
            'description',
            'outsite_url',
            'fb_share',
            'google_share',
            'twitter_share',
            'is_online',
        ];

        $this->checkAndSave($dbobj, $data, $checkFields);

    }

}
