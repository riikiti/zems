<?php

namespace Tests\Feature;

trait StoreProject
{
    public function projectStore(string $token)
    {
        $response = $this->withToken($token)->post('/api/project',
            ['name' => '1234']);
        var_dump($response->json('data.id'));
        return $response->json('data.id');
    }
}
