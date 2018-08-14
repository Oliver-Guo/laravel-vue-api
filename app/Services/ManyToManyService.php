<?php

namespace App\Services;

use App\Models\Model;
use App\Repositories\TagRepository;

class ManyToManyService
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function relation(Model $fromModel, string $toOrm, array $reqIds, array $fields = [])
    {
        $syncIds = [];

        //沒有關聯
        if (empty($reqIds)) {
            return $fromModel->$toOrm()->sync($syncIds);
        }

        //沒有額外其他欄位賦予值
        if (empty($fields)) {
            $syncIds = $reqIds;
            return $fromModel->$toOrm()->sync($syncIds);
        }

        //有額外其他欄位賦予值
        foreach ($reqIds as $sort => $reqId) {

            foreach ($fields as $field => $value) {

                switch ($field) {
                    case 'sort':
                        $syncIds[$reqId][$field] = $sort + $value;
                        break;
                    default:
                        $syncIds[$reqId][$field] = $value;
                        break;
                }

            }

        }

        return $fromModel->$toOrm()->sync($syncIds);
    }

    public function relationTag(Model $fromModel, array $reqNames)
    {
        $syncIds = [];

        if (empty($reqNames)) {
            return $fromModel->tag()->sync($syncIds);
        }

        foreach ($reqNames as $reqName) {

            $checkTag = $this->tagRepository->getCheckOneField('name', $reqName);

            if (!is_null($checkTag)) {
                $syncIds[] = $checkTag->id;
            } else {
                $tag       = $this->tagRepository->checkAndCreate(['name' => $reqName]);
                $syncIds[] = $tag->id;
            }

        }

        return $fromModel->tag()->sync($syncIds);
    }
}
