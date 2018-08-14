<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait DbModel
{
    /**
     * [getOne description]. 抓無資料 會拋出例外.
     *
     * @param [type] $id [description]
     *
     * @return [type] [description]
     */
    public function getOne($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * [getCheckOne description]  抓無資料 不會拋出例外.
     *
     * @param [type] $id [description]
     *
     * @return [type] [description]
     */
    public function getCheckOne($id)
    {
        return $this->model->find($id);
    }

    public function firstOrCreate($data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function getCheckOneField($field, $value)
    {
        $result = $this->model
            ->where($field, $value)
            ->first();

        return $result;
    }

    /**
     * [updateOneField description] 更新條件下的某一個欄位.
     *
     * @param [type] $keyId id 如果是陣列 key 是欄位 value 是要更新的資料
     * @param [type] $field 修改欄位
     * @param [type] $value 資料
     * @param bool   $user  使用者是否紀錄
     *
     * @return [type] [description]
     */
    public function updateOneField($keyId, $field, $value, $user = false)
    {
        $key = 'id';
        $id  = $keyId;
        if (is_array($keyId)) {
            $key = key($keyId);
            $id  = $keyId[$key];
        }

        $updateData[$field] = $value;

        if ($user) {
            $updateData['updated_user'] = is_null(auth()->user()) ? 1 : auth()->user()->id;
        }

        $this->model
            ->where($key, $id)
            ->update($updateData);

        return;
    }

    public function checkAndCreate($data, $checkFields = null, $user = false)
    {
        $createData = [];

        if (is_null($checkFields)) {
            $createData = $data;
        } else {
            foreach ($checkFields as $field) {
                if (array_key_exists($field, $data)) {
                    $createData[$field] = trim($data[$field]);
                }
            }

        }

        if ($user) {
            $createData['created_user'] = is_null(auth()->user()) ? 1 : auth()->user()->id;
        }

        return $this->model->create($createData);
    }

    /*
     *model save 會觸發存取器
     */
    public function checkAndSave(Model $dbObj, $data, $checkFields = null, $user = false)
    {
        if (is_null($checkFields)) {

            foreach ($data as $field => $vaule) {
                $dbObj->$field = $vaule;
            }

        } else {
            foreach ($checkFields as $field) {
                if (array_key_exists($field, $data)) {
                    $dbObj->$field = trim($data[$field]);
                }
            }
        }

        if ($user) {
            $dbObj->updated_user = is_null(auth()->user()) ? 1 : auth()->user()->id;
        }

        return $dbObj->save();
    }

    /*
     *model update 不會觸發存取器
     */
    public function checkAndUpdate($keyId, $data, $checkFields = null, $user = false)
    {
        $updateData = [];

        $key = 'id';
        $id  = $keyId;
        if (is_array($keyId)) {
            $key = key($keyId);
            $id  = $keyId[$key];
        }

        if (is_null($checkFields)) {
            $updateData = $data;
        } else {
            foreach ($checkFields as $field) {
                if (array_key_exists($field, $data)) {
                    $updateData[$field] = trim($data[$field]);
                }
            }
        }

        if ($user) {
            $updateData['updated_user'] = is_null(auth()->user()) ? 1 : auth()->user()->id;
        }

        $this->model
            ->where($key, $id)
            ->update($updateData);

        return;
    }

    /*
     *$data = [
     *['id' => 1, 'name' => 'Jeff'],
     *['id' => 3, 'name' => 'Mark'],
     *['id' => 5, 'name' => 'Jim'],
     *];
     */
    public function updateValues(array $values, string $field)
    {
        $table = $this->model->getModel()->getTable();

        $cases  = [];
        $ids    = [];
        $params = [];

        foreach ($values as $key => $value) {
            $id       = (int) $value['id'];
            $cases[]  = "WHEN {$id} then ?";
            $params[] = $value[$field];
            $ids[]    = $id;
        }

        $ids      = implode(',', $ids);
        $cases    = implode(' ', $cases);
        $params[] = Carbon::now()->getTimestamp();

        return \DB::update("UPDATE `{$table}` SET `{$field}` = CASE `id` {$cases} END, `updated_at` = ? WHERE `id` in ({$ids})", $params);
    }
}
