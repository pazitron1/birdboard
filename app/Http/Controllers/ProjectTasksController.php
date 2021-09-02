<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProjectTasksController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate([
            'body' => 'required'
        ]);
        $project->addTask(request('body'));

        return redirect($project->path());
    }

    /**
     * @param Project $project
     * @param Task $task
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Project $project, Task $task): RedirectResponse
    {
        $this->authorize('update', $task->project);

        $attributes = request()->validate([
            'body' => 'required'
        ]);

        $task->update($attributes);

        $method = request('completed') ? 'complete' : 'incomplete';

        $task->$method();

        return redirect()->back();
    }
}
