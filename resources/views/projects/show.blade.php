@extends('layouts.app')

@section('content')
    <header class="my-4">
        <x-breadcrumbs>
            <x-breadcrumb-item>{{ $project->title }}</x-breadcrumb-item>
        </x-breadcrumbs>
    </header>

    <div class="flex space-x-6">
        <div class="w-3/4">
            <div class="mb-8">
                <h2 class="text-gray-500 text-lg" mb-3>Tasks</h2>
                @foreach($project->tasks as $task)
                    <x-card>
                        {{ $task->body }}
                    </x-card>
                @endforeach
                <x-card>
                    <form action="{{ route('projects.tasks.store', $project) }}" method="POST">
                        @csrf
                        <label class="sr-only" for="body">Task name</label>
                        <input name="body" class="w-full outline-none focus:outline-none" placeholder="Add a new task">
                    </form>
                </x-card>
            </div>
            <div class="mb-8">
                <h2 class="text-gray-500 text-lg mb-3">General notes</h2>
                <x-card>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos necessitatibus, suscipit voluptatibus ullam ea eligendi ad debitis deserunt, modi maxime explicabo nesciunt assumenda esse accusantium sunt, ab repellendus iusto saepe.
                </x-card>
            </div>
        </div>
        <div class="w-1/4">
            <x-card class="h-40">
                <x-project.card :project="$project"></x-project.card>
            </x-card>
        </div>
    </div>
@endsection
