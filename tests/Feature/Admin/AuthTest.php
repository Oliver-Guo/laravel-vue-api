<?php

namespace TEST\Feature\Admin;

use Tests\ApiAdminTestCase;

class AuthTest extends ApiAdminTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        //$this->headers = $this->headers(7);
    }

    public function testAdminLogin()
    {
        $response = $this->json('POST', '/api/admin/login', ['email' => 'bb@bb.bb', 'password' => '123456']);
        //$response = $this->post('/api/admin/login', ['email' => 'bb@bb.bb', 'password' => '123456']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'token_type' => 'bearer',
            ]);

        $this->assertTrue(is_string($response->json()['access_token']));

        return $response->json()['access_token'];
    }

    /**
     * @depends testAdminLogin
     */
    public function testGetMe($token)
    {
        $response = $this->json('GET', '/api/admin/me', [], ['Authorization' => 'Bearer ' . $token]);
        //$response = $this->get('/api/admin/me', ['Authorization' => 'Bearer ' . $token]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'email' => 'bb@bb.bb',
            ]);

    }

    /**
     * @depends testAdminLogin
     */
    public function testRefresh($token)
    {
        $response = $this->json('GET', '/api/admin/refresh', [], ['Authorization' => 'Bearer ' . $token]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'token_type' => 'bearer',
            ]);

        $this->assertTrue(is_string($response->json()['access_token']));

        return $response->json()['access_token'];
    }

    /**
     * @depends testRefresh
     */
    public function testLogout($token)
    {
        $response = $this->json('GET', '/api/admin/logout', [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }
}
