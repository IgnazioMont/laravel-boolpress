<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Welcome admin</h1>

    <p>Here's a new post created: {{ $new_post->title }}. 
        <a href="{{ route('admin.posts.show', ['post' => $new_post->id]) }}">Click here!</a>
    </p>
</body>
</html>