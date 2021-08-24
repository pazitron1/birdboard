@props([
    'project' => '',
    'action',
    'method'
])
<form class="max-w-lg mx-auto" method="POST" action="{{ $action }}">
    @csrf
    @method("$method")
    {{ $slot }}
</form>
