<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    /**
     * @param Project $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Project $project)
    {
        abort_if(
            auth()
                ->user()
                ->isNot($project->owner),
            403
        );
        request()->validate([
            'body' => 'required'
        ]);
        $project->addTask(request('body'));

        return redirect($project->path());
    }
}
