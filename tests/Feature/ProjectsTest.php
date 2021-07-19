<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        //Arrange
        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph()
        ];

        //Act
        $this->post('projects', $attributes)->assertRedirect('projects');

        //Assert
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('projects')->assertSee($attributes{'title'});
    }
}
