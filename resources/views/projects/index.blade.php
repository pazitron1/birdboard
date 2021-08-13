@extends('layouts.app')

@section('content')
    <header class="my-4">
        <h1 class="text-gray-400 text-2xl">My projects</h1>
    </header>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4">
        @forelse($projects as $project)
            <div class="bg-white mr-4 rounded-md shadow w-full p-5" style="height:200px;">
                <a href="{{$project->path()}}" class="text-lg py-2 font-normal -ml-5 border-l-2 pl-4 border-indigo-500">{{ $project->title }}</a>
                <div class="text-sm text-gray-500 mt-4">{{ Str::limit($project->description, 150) }}</div>
            </div>
        @empty
            <div>No projects yet...</div>
        @endforelse
    </div>
@endsection
