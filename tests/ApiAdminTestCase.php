<?php

namespace Tests;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class ApiAdminTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function headers($userId)
    {
        $user  = User::where('id', $userId)->first();
        $token = Auth::guard()->fromUser($user);

        $headers                  = ['Accept' => 'application/json'];
        $headers['Authorization'] = 'Bearer ' . $token;

        return $headers;
    }
}
