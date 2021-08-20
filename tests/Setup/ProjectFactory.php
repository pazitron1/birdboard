<?php

namespace Tests\Setup;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class ProjectFactory
{
    /**
     * @var int
     */
    protected int $tasksCount = 0;

    /**
     * @var User
     */
    protected User $user;

    /**
     * @return Collection|Model
     */
    public function create()
    {
        $project = Project::factory()->create([
            'owner_id' => $this->user ?? User::factory()->create()
        ]);

        Task::factory()
            ->count($this->tasksCount)
            ->create([
                'project_id' => $project->id
            ]);

        return $project;
    }

    /**
     * @param $count
     * @return $this
     */
    public function withTasks($count): ProjectFactory
    {
        $this->tasksCount = $count;

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function ownedBy(User $user): ProjectFactory
    {
        $this->user = $user;

        return $this;
    }
}
