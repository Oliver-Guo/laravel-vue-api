<?php

namespace App\Http\Controllers\Api\Admin;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    public function __construct()
    {
        config(['auth.defaults.guard' => 'users']);

        $this->middleware('jwt');
    }

}
