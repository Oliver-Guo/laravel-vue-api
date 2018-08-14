<?php

namespace App\Http\Controllers\Api\Admin\Author;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\Author\AuthorCreateRequest;
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
        $this->middleware('permission:author_del', ['only' => ['destroy', 'deletes']]);
        $this->authorRepository = $authorRepository;
    }

    public function index(Request $request)
    {
        $search = $request->all();

        $authors = $this->authorRepository->getList($search);

        $authors->load(['photo' => function ($query) {
            $query->selectRaw('imageable_id,CONCAT(path,name) name');
        }]);

        return $this->response->array($authors);
    }

    public function store(AuthorCreateRequest $request)
    {

        $reqAuthor = $request->input('author');

        $author = $this->authorRepository->create($reqAuthor);

        return $this->uploadPhoto($request, 'author', $author);
    }

    public function show($id)
    {

        $author = $this->authorRepository->getOne($id);

        $author->load(['photo' => function ($query) {
            $query->selectRaw('imageable_id,CONCAT(path,name) name');
        }]);

        return $this->response->array($author);
    }

    public function update($id, AuthorCreateRequest $request)
    {
        $reqAuthor = $request->input('author');

        $author = $this->authorRepository->getOne($id);

        $this->authorRepository->update($id, $reqAuthor);

        return $this->uploadPhoto($request, 'author', $author);
    }

    public function destroy($id)
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

    public function allList()
    {
        $result = $this->authorRepository->getAllList();

        return $this->response->array($result);
    }
}
