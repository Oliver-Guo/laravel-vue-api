<?php

namespace App\Http\Controllers\Api\Admin\Topic;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\Topic\TopicCreateRequest;
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

        $topics->load(['photo' => function ($query) {
            $query->selectRaw('imageable_id,CONCAT(path,name) name');
        }]);

        $topics->load(['author' => function ($query) {
            $query->selectRaw('id,name');
        }]);

        $topics->load(['topicCategory' => function ($query) {
            $query->select('id', 'name');
        }]);

        $topics->load(['tag' => function ($query) {
            $query->select('id', 'name');
        }]);

        return $this->response->array($topics);
    }

    public function store(TopicCreateRequest $request)
    {
        $reqTopic = $request->input('topic');

        $topic = $this->topicRepository->create($reqTopic);

        $tag_names = (!empty($request->input('tag_names'))) ? $request->input('tag_names') : [];
        $this->manyToManyService->relationTag($topic, $tag_names);

        $reqArticleIds = (!empty($request->input('article_ids'))) ? $request->input('article_ids') : [];
        $this->manyToManyService->relation($topic, 'article', $reqArticleIds, ['sort' => 1]);

        return $this->uploadPhoto($request, 'topic', $topic);
    }

    public function show($id)
    {
        $topic = $this->topicRepository->getOne($id);

        $topic->load(['photo' => function ($query) {
            $query->selectRaw('imageable_id,CONCAT(path,name) name');
        }]);

        $topic->load(['article' => function ($query) {
            $query->selectRaw('id,title')
                ->orderBy('article_topic.sort', 'asc');
        }]);

        $topic->load(['tag' => function ($query) {
            $query->selectRaw('id,name');
        }]);

        return $this->response->array($topic);
    }

    public function update($id, TopicCreateRequest $request)
    {
        $topic = $this->topicRepository->getOne($id);

        $tag_names = (!empty($request->input('tag_names'))) ? $request->input('tag_names') : [];
        $this->manyToManyService->relationTag($topic, $tag_names);

        $reqArticleIds = (!empty($request->input('article_ids'))) ? $request->input('article_ids') : [];
        $this->manyToManyService->relation($topic, 'article', $reqArticleIds, ['sort' => 1]);

        $reqTopic = $request->input('topic');

        $this->topicRepository->update($id, $reqTopic);

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
        $this->topicRepository->updateOneField($id, 'is_online', $request->input('is_online'));

        return $this->response->array(['code' => 1]);
    }
}
