<?php

namespace App\Http\Requests\Api\Admin\Permission;

use App\Http\Requests\Api\FormRequest;

class UserCreateRequest extends FormRequest
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
            'user.name'     => 'required|max:255',
            'user.email'    => 'required|email|max:255',
            'user.password' => 'required|min:6|max:12|confirmed',

        ];
    }
}
