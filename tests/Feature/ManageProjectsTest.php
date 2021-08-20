<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
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
        $this->signIn();

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'notes' => 'Test notes'
        ];

        $this->get('projects/create')->assertOk();
        $response = $this->post('projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch(
                $project->path(),
                $attributes = [
                    'notes' => 'Updated notes'
                ]
            )
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
        $this->get($project->path())->assertSee('Updated notes');
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = Project::factory()->raw([
            'title' => '',
            'description' => 'Description goes here...'
        ]);
        $this->post('projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = Project::factory()->raw([
            'title' => 'Test title',
            'description' => ''
        ]);
        $this->post('projects', $attributes)->assertSessionHasErrors(
            'description'
        );
    }

    /** @test */
    public function a_project_description_cannot_be_more_than_255_characters()
    {
        $this->signIn();
        $attributes = Project::factory()->raw([
            'title' => 'Test title',
            'description' => $this->faker->paragraph(20)
        ]);
        $this->post('projects', $attributes)->assertSessionHasErrors(
            'description'
        );
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);
    }
}
