<?php

namespace App\Http\Controllers\Api\Admin\Topic;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\Topic\TopicCategoryCreateRequest;
use App\Repositories\TopicCategoryRepository;
use Illuminate\Http\Request;

class TopicCategoryController extends Controller
{
    protected $topicCategoryRepository;

    public function __construct(TopicCategoryRepository $topicCategoryRepository)
    {
        parent::__construct();

        $this->middleware('permission:topic_category_list', ['only' => ['index']]);
        $this->middleware('permission:topic_category_add', ['only' => ['store']]);
        $this->middleware('permission:topic_category_edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:topic_category_del', ['only' => ['destroy']]);

        $this->topicCategoryRepository = $topicCategoryRepository;
    }

    public function index(Request $request)
    {
        $search = $request->all();

        $result = $this->topicCategoryRepository->getList($search);

        return $this->response->array($result);
    }

    public function store(TopicCategoryCreateRequest $request)
    {
        $reqTopicCategory = $request->input('topic_category');

        $author = $this->topicCategoryRepository->create($reqTopicCategory);

        return $this->response->array('');
    }

    public function show($id)
    {
        $topicCategory = $this->topicCategoryRepository->getOne($id);

        return $this->response->array($topicCategory);
    }

    public function update($id, TopicCategoryCreateRequest $request)
    {
        $reqTopicCategory = $request->input('topic_category');

        $topicCategory = $this->topicCategoryRepository->getOne($id);

        $this->topicCategoryRepository->update($id, $reqTopicCategory);

        return $this->response->array('');
    }

    public function destroy($id)
    {
        $topicCategory = $this->topicCategoryRepository->getOne($id);

        if (!$topicCategory->topic->isEmpty()) {

            return $this->response->error('分類有關聯專題不可刪除.', 403);

        }

        $topicCategory->delete();

        return $this->response->array('');
    }

    //隱藏顯示
    public function chIsOnline($id, Request $request)
    {
        $this->topicCategoryRepository->updateOneField($id, 'is_online', $request->input('is_online'));

        return $this->response->array(['code' => 1]);
    }

    //拖拉排序
    public function chSort(Request $request)
    {
        $ids = $request->input('ids');

        $data = [];

        $sort = 1;

        foreach ($ids as $key => $id) {
            $data[] = ['id' => $id, 'sort' => $sort++];
        }

        $this->topicCategoryRepository->updateValues($data, 'sort');

        return $this->response->array(['code' => 1]);
    }
}
