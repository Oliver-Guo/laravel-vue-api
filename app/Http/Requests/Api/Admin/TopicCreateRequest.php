<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Requests\Api\FormRequest;

class TopicCreateRequest extends FormRequest
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
            'topic.topic_category_id' => 'required|integer',
            'topic.author_id'         => 'required|integer',
            'topic.title'             => 'required',
            'topic.description'       => 'required',
            'topic.is_online'         => 'required|integer|in:0,1',
            'topic.sort'              => 'integer',
            'tag_names'               => 'array',
            'article_ids'             => 'array',
        ];
    }
}
