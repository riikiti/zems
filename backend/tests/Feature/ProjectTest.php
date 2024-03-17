<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\StoreProject;

class ProjectTest extends Auth
{
    use StoreProject;

    protected string $project_id;

    public function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->project_id = $this->projectStore($this->token);
    }

    public function testProjectIndex(): void
    {
        $response = $this->withToken($this->token)->get('/api/project');
        $response->assertStatus(200);
    }

    public function testProjectShow(): void
    {
        $response = $this->withToken($this->token)->get('/api/project/' . $this->project_id);
        $response->assertStatus(200)->assertJsonStructure([
            'data'=>[
                'id'
            ]
        ]);
    }

    public function testProjectDelete(): void
    {
        $response = $this->withToken($this->token)->delete('/api/project/' . $this->project_id);
        $response->assertStatus(200);
    }
}
