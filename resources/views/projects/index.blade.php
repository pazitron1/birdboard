@extends('layouts.app')

@section('content')
    <header class="my-4">
        <h1 class="text-gray-500 text-2xl">My projects</h1>
    </header>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4">
        @forelse($projects as $project)
            <x-card class="h-40">
                <x-project.card :project="$project"></x-project.card>
            </x-card>
        @empty
            <div>No projects yet...</div>
        @endforelse
    </div>
@endsection
