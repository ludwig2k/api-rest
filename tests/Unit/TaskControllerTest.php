<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    public function testGetAllTasks()
    {
        Task::factory()->count(5)->create();

        $response = $this->call('GET', '/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function testCreateTaskWithValidData()
    {
        $data = [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'completed' => false,
        ];

        $response = $this->post('/api/tasks', $data);

        $response->assertStatus(201)
            ->assertJson($data);
    }

    public function testCreateTaskWithMissingRequiredField()
    {
        $data = [
            'description' => 'Task Description',
            'completed' => false,
        ];

        $response = $this->post('/api/tasks', $data);

        $response->assertStatus(400)
            ->assertJsonMissingValidationErrors('title');
    }

    public function testGetTaskById()
{
    $task = Task::factory()->create([
        'completed' => 1,
    ]);

    $response = $this->get('/api/tasks/' . $task->id);

    $response->assertStatus(200)
        ->assertJsonFragment(['completed' => 1]);
}


    public function testGetTaskByInvalidId()
    {
        $response = $this->get('/api/tasks/999');

        $response->assertStatus(404)
            ->assertJson(['error' => 'Task not found']);
    }

    public function testUpdateTask()
    {
        $task = Task::factory()->create();

        $updatedData = [
            'title' => 'Updated Task Title',
            'completed' => true,
        ];

        $response = $this->put('/api/tasks/' . $task->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson($updatedData);
    }

    public function testUpdateTaskWithInvalidId()
    {
        $response = $this->put('/api/tasks/999', []);

        $response->assertStatus(404)
            ->assertJson(['error' => 'Task not found']);
    }

    public function testDeleteTask()
    {
        $task = Task::factory()->create();

        $response = $this->delete('/api/tasks/' . $task->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testDeleteTaskWithInvalidId()
    {
        $response = $this->delete('/api/tasks/999');

        $response->assertStatus(404)
            ->assertJson(['error' => 'Task not found']);
    }
}
