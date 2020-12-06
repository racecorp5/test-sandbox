<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

use \App\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testFrontPage()
    {
        $this->get('/')
            ->assertSee('Laravel');
    }

    public function testIndexRoute()
    {
        $this->get('api/v1/tasks')
            ->assertJson([]);
    }

    public function testCreateRoute()
    {
        $data = [
            'title' => 'Test Task',
            'due_date' => Carbon::now(),
            'is_done' => false,
        ];
        $this->post('api/v1/tasks', $data)
            ->assertJsonFragment(['title' => 'Test Task'])
            ->assertStatus(201);
    }

    public function testReadRoute()
    {
        $tasks = factory(Task::class, 3)->create();

        $id = 2;
        $this->get('/api/v1/tasks/' . $id)
            ->assertStatus(200)
            ->assertJsonFragment(['id' => 2]);
    }

    public function testUpdateRoute()
    {
        $tasks = factory(Task::class, 3)->create();
        $data = [
            'title' => 'Test Task',
            'is_done' => true,
        ];
        $id = 2;
        $this->put('/api/v1/tasks/' . $id, $data)
            ->assertJsonFragment(['title' => 'Test Task'])
            ->assertStatus(200);
    }

    public function testDeleteRoute()
    {
        $tasks = factory(Task::class, 3)->create();
        $id = 2;

        $this->delete('/api/v1/tasks/' . $id)
            ->assertStatus(204);
    }

}
