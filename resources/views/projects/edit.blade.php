@extends('layouts.app')

@section('content')
    <h1>Edit project</h1>
    <x-form
        :project="$project"
        :action="route('projects.update', $project)"
        method="PATCH">

        <div class="mb-4">
            <x-label>Title</x-label>
            <x-input
                :value="$project->title"
                type="text"
                name="title"
                placeholder="Awesome project">
            </x-input>
            <x-validation-error for="title"></x-validation-error>
        </div>

        <div class="mb-4">
            <x-label>Description</x-label>
            <div class="mt-1">
                <x-textarea name="description" rows="5">
                    {{ $project->description }}
                </x-textarea>
                <x-validation-error for="description"></x-validation-error>
            </div>
        </div>

        <div class="flex items-center space-x-3 mt-4">
            <x-button type="submit">Update Project</x-button>
            <x-link-button link="{{ $project->path() }}">Cancel</x-link-button>
        </div>

    </x-form>
@endsection
