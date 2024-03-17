<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Auth extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    public function register(): void
    {
        $response = $this->post('/api/auth/register',
            ['email' => 'admin@admin.com', 'password' => '06062001', 'confirm_password' => '06062001', 'name' => 'admin', 'role' => 'admin']);
        $response->assertStatus(200);
    }

    public function login(): void
    {
        $this->register();
        $response = $this->post('/api/auth/login',
            ['email' => 'admin@admin.com', 'password' => '06062001']);
        $response->assertStatus(200)->assertJsonStructure([
            "access_token"
        ]);
        $this->token = $response->json('access_token');
    }
}
