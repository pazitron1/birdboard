<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create project</title>
</head>
<body>
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
        </div>
    </form>
</body>
</html>
