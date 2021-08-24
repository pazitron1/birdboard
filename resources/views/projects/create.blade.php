@extends('layouts.app')

@section('content')
    <h1>New project</h1>
    <x-form
        :action="route('projects.store')"
        method="POST">

        <div class="mb-4">
            <x-label>Title</x-label>
            <x-input
                type="text"
                name="title"
                placeholder="Awesome project">
            </x-input>
        </div>

        <div class="mb-4">
            <x-label>Description</x-label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <x-textarea name="description" rows="5"></x-textarea>
            </div>
        </div>

        <div class="flex items-center space-x-3 mt-4">
            <x-button type="submit">Create Project</x-button>
            <x-link-button link="{{ route('projects.index') }}">Cancel</x-link-button>
        </div>

    </x-form>
@endsection
