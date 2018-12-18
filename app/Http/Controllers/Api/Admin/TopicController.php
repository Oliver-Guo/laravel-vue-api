<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\TopicCreateRequest;
use App\Repositories\TopicRepository;
use App\Services\ManyToManyService;
use App\Traits\UploadPhoto;
use Illuminate\Http\Request;
use Storage;

class TopicController extends Controller
{
    use UploadPhoto;

    protected $manyToManyService;
    protected $topicRepository;

    public function __construct(ManyToManyService $manyToManyService, TopicRepository $topicRepository)
    {
        parent::__construct();

        $this->middleware('permission:topic_list', ['only' => ['index']]);
        $this->middleware('permission:topic_add', ['only' => ['store']]);
        $this->middleware('permission:topic_edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:topic_del', ['only' => ['destroy']]);

        $this->manyToManyService = $manyToManyService;
        $this->topicRepository   = $topicRepository;
    }

    public function index(Request $request)
    {
        $search = $request->all();

        $topics = $this->topicRepository->getList($search);

        return $this->response->array($topics);
    }

    public function store(TopicCreateRequest $request)
    {
        $reqTopic = $request->topic;

        $topic = $this->topicRepository->create($reqTopic);

        $tag_names = empty($request->input('tag_names')) ? [] : $request->input('tag_names');
        $this->manyToManyService->relationTags($topic, $tag_names);

        $reqArticleIds = empty($request->input('article_ids')) ? [] : $request->input('article_ids');
        $this->manyToManyService->relation($topic, 'articles', $reqArticleIds, ['sort' => 1]);

        return $this->uploadPhoto($request, 'topic', $topic);
    }

    public function show($id)
    {
        $topic = $this->topicRepository->getShow($id);

        return $this->response->array($topic);
    }

    public function update($id, TopicCreateRequest $request)
    {
        $topic = $this->topicRepository->getOne($id);

        $tag_names = empty($request->input('tag_names')) ? [] : $request->input('tag_names');
        $this->manyToManyService->relationTags($topic, $tag_names);

        $reqArticleIds = empty($request->input('article_ids')) ? [] : $request->input('article_ids');
        $this->manyToManyService->relation($topic, 'articles', $reqArticleIds, ['sort' => 1]);

        $reqTopic = $request->topic;

        $this->topicRepository->update($topic, $reqTopic);

        return $this->uploadPhoto($request, 'topic', $topic);
    }

    public function destroy($id)
    {
        $topic = $this->topicRepository->getOne($id);

        if (!is_null($topic->photo)) {

            Storage::delete(config('filesystems.upload_path') . $topic->photo->path . $topic->photo->name);

        }

        $topic->delete();

        return $this->response->array('');
    }

    public function chIsOnline($id, Request $request)
    {

        $reqIsOnline = (int) $request->is_online === 1 ? 1 : 0;

        $this->topicRepository->updateOneField($id, 'is_online', $reqIsOnline);

        return $this->response->array(['code' => 1]);
    }
}
