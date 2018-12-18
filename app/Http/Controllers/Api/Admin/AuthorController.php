<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\AuthorCreateRequest;
use App\Repositories\AuthorRepository;
use App\Traits\UploadPhoto;
use Illuminate\Http\Request;
use Storage;

class AuthorController extends Controller
{
    use UploadPhoto;

    protected $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        parent::__construct();
        $this->middleware('permission:author_list', ['only' => ['index']]);
        $this->middleware('permission:author_add', ['only' => ['store']]);
        $this->middleware('permission:author_edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:author_del', ['only' => ['destroy']]);
        $this->authorRepository = $authorRepository;
    }

    public function index(Request $request)
    {
        $search = $request->all();

        $authors = $this->authorRepository->getList($search);

        return $this->response->array($authors);
    }

    public function store(AuthorCreateRequest $request)
    {

        $reqAuthor = $request->input('author');

        $author = $this->authorRepository->create($reqAuthor);

        return $this->uploadPhoto($request, 'author', $author);
    }

    public function show(int $id)
    {

        $author = $this->authorRepository->getShow($id);

        return $this->response->array($author);
    }

    public function update(int $id, AuthorCreateRequest $request)
    {
        return $this->response->array($request->all());
        $reqAuthor = $request->input('author');

        $author = $this->authorRepository->getOne($id);

        $this->authorRepository->update($author, $reqAuthor);

        return $this->uploadPhoto($request, 'author', $author);
    }

    public function destroy(int $id)
    {
        $author = $this->authorRepository->getOne($id);

        if ($author->article()->count() >= 1) {
            return $this->response->error('作者有關聯文章不可刪除.', 403);
        }

        if (!is_null($author->photo)) {
            Storage::delete(config('filesystems.upload_path') . $author->photo->path . $author->photo->name);
        }

        $author->delete();

        return $this->response->array('');
    }

    //隱藏顯示
    public function chIsOnline(int $id, Request $request)
    {
        $reqIsOnline = (int) $request->is_online === 1 ? 1 : 0;

        $this->authorRepository->updateOneField($id, 'is_online', $reqIsOnline);

        return $this->response->array(['code' => 1]);
    }

    public function selects()
    {
        $result = $this->authorRepository->getSelects();

        return $this->response->array($result);
    }
}
