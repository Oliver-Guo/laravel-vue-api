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

    /**
     * relation 多對多關聯
     * @param  Model  $fromModel 主物件
     * @param  string $toOrm orm對象
     * @param  array  $reqIds 關聯ids
     * @param  array  $fields 關聯附加資訊
     */
    public function relation(Model $fromModel, string $toOrm, array $reqIds, array $fields = [])
    {
        $syncIds = [];

        //沒有關聯
        if (empty($reqIds)) {
            $fromModel->$toOrm()->sync($syncIds);
            return;
        }

        //沒有額外其他欄位賦予值
        if (empty($fields)) {
            $syncIds = $reqIds;
            $fromModel->$toOrm()->sync($syncIds);
            return;
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

        $fromModel->$toOrm()->sync($syncIds);

        return;
    }

    /**
     * relationTags 多對多關聯TAG
     * @param  Model  $fromModel 主物件
     * @param  array  $reqNames  TAG名稱

     */
    public function relationTags(Model $fromModel, array $reqNames)
    {
        $syncIds = [];

        if (empty($reqNames)) {
            return $fromModel->tags()->sync($syncIds);
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

        $fromModel->tags()->sync($syncIds);
    }
}
