<?php

namespace App\Repositories;

use App\Models\Author;
use App\Traits\DbModel;

class AuthorRepository
{
    use DbModel;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    public function getList(array $search)
    {
        $paginate = (!empty($search['paginate']) && (int) $search['paginate'] > 0) ? $search['paginate'] : 20;

        return $this->model
            ->select('id', 'name', 'is_online')
            ->where(function ($query) use ($search) {
                if (!empty($search['keyword'])) {
                    $query->where('name', 'like', '%' . $search['keyword'] . '%');
                }
            })
            ->orderBy('id', 'asc')
            ->paginate($paginate);
    }

    public function getAllList()
    {
        return $this->model
            ->select('id', 'name')
            ->orderBy('id', 'asc')
            ->get();
    }

    public function create($data)
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

    public function update($id, $data)
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

        $this->checkAndUpdate($id, $data, $checkFields);

        return;
    }

    public function getWillDel(array $ids)
    {

        return $this->model
            ->select('id')
            ->whereIn('id', $ids)
            ->with('photo')
            ->withCount('article')
            ->get();
    }
}
