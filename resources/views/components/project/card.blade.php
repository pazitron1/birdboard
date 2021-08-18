@props([
    'project'
])
<a href="{{$project->path()}}" class="text-lg py-2 font-normal -ml-5 border-l-2 pl-4 border-indigo-500">{{ $project->title }}</a>
<div class="text-sm text-gray-500 mt-4">{{ Str::limit($project->description, 255) }}</div>
