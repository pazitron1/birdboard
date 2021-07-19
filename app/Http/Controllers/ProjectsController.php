<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        Project::create([
            'title' => request('title'),
            'description' => request('description')
        ]);

        return redirect(route('projects.index'));
    }
}
