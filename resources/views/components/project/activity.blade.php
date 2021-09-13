@props([
    'project'
])
<ul class="text-xs list-none space-y-1 text-gray-500">
    @foreach($project->activity as $activity)
        @if($activity->description === "created")
            <li>You project created <span class="text-gray-400">{{$activity->created_at->diffForHumans(null, null, true)}}</span></li>

        @elseif($activity->description === 'updated')
            <li>You updated the project <span class="text-gray-400">{{$activity->created_at->diffForHumans(null, null, true)}}</span></li>

        @elseif($activity->description === 'task_created')
            <li>You created <b>{{ $activity->subject->body }}</b> <span class="text-gray-400">{{$activity->created_at->diffForHumans(null, null, true)}}</span></li>

        @elseif($activity->description === 'task_completed')
            <li>You completed <b>{{ $activity->subject->body }}</b> <span class="text-gray-400">{{$activity->created_at->diffForHumans(null, null, true)}}</span></li>

        @elseif($activity->description === 'task_incompleted')
            <li>You incompleted  <b>{{ $activity->subject->body }}</b> <span class="text-gray-400">{{$activity->created_at->diffForHumans(null, null, true)}}</span></li>

        @else
            <li>{{ $activity->description }} <span class="text-gray-400">{{$activity->created_at->diffForHumans(null, null, true)}}</span></li>
        @endif
    @endforeach
</ul>
