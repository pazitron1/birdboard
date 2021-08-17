<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_control_a_project()
    {
        $project = Project::factory()->create();

        $this->post('projects', $project->toArray())->assertRedirect('login');
        $this->get('projects')->assertRedirect('login');
        $this->get('projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'owner_id' => auth()->id()
        ];

        $this->get('projects/create')->assertOk();
        $response = $this->post('projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $this->post('projects', [])->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->signIn();
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }
}
