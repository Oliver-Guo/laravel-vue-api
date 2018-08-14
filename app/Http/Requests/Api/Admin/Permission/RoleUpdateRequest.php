<?php

namespace App\Http\Requests\Api\Admin\Permission;

use App\Http\Requests\Api\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role.name'         => 'required',
            'role.display_name' => 'required',
            'permission_ids'    => 'array',
            'permission_ids.*'  => 'integer',
        ];
    }

    public function messages()
    {
        return config('constants.validatorMessages');
    }

    public function attributes()
    {
        return [
            'role.name'         => '角色權限名稱',
            'role.display_name' => '角色權限代號',
            'permission_ids.*'  => '操作異常(請重新整理)',
        ];
    }
}
