<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path() . '/tasks', [
            'body' => 'Test task'
        ]);
        $this->get($project->path())->assertSee('Test task');
    }

    /** @test */
    public function a_project_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');

        $this->assertEquals(0, $project->tasks->count());
    }

    /** @test */
    public function only_the_owner_of_the_project_may_add_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->post($project->path() . '/tasks', [
            'body' => 'Test task'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    /** @test */
    public function only_the_owner_of_the_project_may_update_a_task()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'Changed body',
            'completed' => true
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'Changed body',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch(
            $project->tasks->first()->path(),
            [
                'body' => 'Changed body'
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed body'
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch(
            $project->tasks->first()->path(),
            [
                'body' => 'Changed body',
                'completed' => true
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed body',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_incomplete()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch(
            $project->tasks->first()->path(),
            [
                'body' => 'Changed body',
                'completed' => true
            ]
        );

        $this->actingAs($project->owner)->patch(
            $project->tasks->first()->path(),
            [
                'body' => 'Changed body',
                'completed' => false
            ]
        );

        $this->assertDatabaseHas('tasks', [
            'body' => 'Changed body',
            'completed' => false
        ]);
    }
}
