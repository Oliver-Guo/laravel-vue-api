<?php
namespace App\Http\Controllers\Api\Admin;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    protected $dataTransformer;

    public function __construct()
    {
        $this->middleware('jwt:api');
    }

}
