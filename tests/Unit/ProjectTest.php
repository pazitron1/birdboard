<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory()->make();

        $this->assertEquals('projects/' . $project->id, $project->path());
    }

    /** @test */
    public function a_project_belongs_to_an_owner()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);
        $this->assertEquals('Test task', $project->tasks()->first()->body);
        $this->assertTrue($project->tasks->contains($task));
    }
}
