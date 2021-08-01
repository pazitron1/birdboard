<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_create_a_project()
    {
        $attributes = Project::factory()->raw();

        $this->post('projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function gests_cannot_view_projects()
    {
        $this->get('projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();

        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->be($user = User::factory()->create());

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'owner_id' => $user->id
        ];

        $this->post('projects', $attributes)->assertRedirect('projects');
        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(User::factory()->create());
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(User::factory()->create());
        $this->post('projects', [])->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->actingAs(User::factory()->create());
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->actingAs(User::factory()->create());
        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }
}
