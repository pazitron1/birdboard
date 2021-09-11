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
                        <form class="flex justify-between items-center" action="{{ route('projects.tasks.update', [$project, $task]) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <label class="sr-only" for="body">Task name</label>
                            <input name="body" class="w-full outline-none focus:outline-none {{ $task->completed ? 'text-gray-400 line-through' : 'text-gray-900' }}" value="{{ $task->body }}">
                            <input type="checkbox" name="completed" onChange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                        </form>
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
                <form action="{{ route('projects.update', $project) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <x-card class="mb-4">
                        <textarea
                            class="border-0 w-full outline-none focus:outline-none focus:ring-transparent"
                            name="notes"
                            cols="30"
                            rows="4"
                            placeholder="Any special notes for this project?"
                        >{{ $project->notes }}</textarea>
                    </x-card>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    @endif
                    <button class="mt-4 relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-indigo-500" type="submit">Save</button>
                </form>
            </div>
        </div>
        <div class="w-1/4">
            <x-card class="h-40">
                <x-project.card :project="$project"></x-project.card>
            </x-card>

            <x-card class="mt-4">
                <x-project.activity :project="$project"></x-project.activity>
            </x-card>
            <a class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('projects.edit', $project) }}">Edit project</a>
        </div>
    </div>
@endsection
