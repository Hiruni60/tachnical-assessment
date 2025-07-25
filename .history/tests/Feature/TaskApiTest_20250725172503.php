<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_tasks()
    {
        Task::factory()->count(2)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'title', 'description', 'is_completed', 'created_at', 'updated_at']
                 ]);
    }

    /** @test */
    public function it_can_create_a_task()
    {
        $data = [
            'title' => 'My test task',
            'description' => 'Test description'
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'My test task']);

        $this->assertDatabaseHas('tasks', ['title' => 'My test task']);
    }

    /** @test */
    public function it_can_mark_a_task_as_complete()
    {
        $task = Task::factory()->create(['completed' => false]);

        $response = $this->patchJson("/api/tasks/{$task->id}/complete");

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }
}
