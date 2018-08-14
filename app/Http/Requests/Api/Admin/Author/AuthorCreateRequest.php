<?php

namespace App\Http\Requests\Api\Admin\Author;

use App\Http\Requests\Api\FormRequest;

class AuthorCreateRequest extends FormRequest
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
            'author.name'        => 'required',
            'author.description' => 'required',
            'author.is_online'   => 'required|integer|in:0,1',
        ];
    }
}
