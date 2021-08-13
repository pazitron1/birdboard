@extends('layouts.app')

@section('content')
    <h1>New project</h1>
    <form method="POST" action="{{route('projects.store')}}">
        @csrf
        <div>
            <input type="text" name="title" placeholder="Title">
        </div>

        <div>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
        </div>

        <div>
            <button type="submit">Create project</button>
            <a href="/projects">Cancel</a>
        </div>
    </form>
@endsection
