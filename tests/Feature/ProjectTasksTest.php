<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()
            ->user()
            ->projects()
            ->create(Project::factory()->raw());

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);
        $this->get($project->path())->assertSee('Test task');
    }

    /** @test */
    public function a_project_task_requires_a_body()
    {
        $this->signIn();

        $project = auth()
            ->user()
            ->projects()
            ->create(Project::factory()->raw());

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post(
            $project->path() . '/tasks',
            $attributes
        )->assertSessionHasErrors('body');

        $this->assertEquals(0, $project->tasks->count());
    }

    /** @test */
    public function only_the_owner_of_the_project_may_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', [
            'body' => 'Test task'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }
}
