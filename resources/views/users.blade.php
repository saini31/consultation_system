<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
</head>

<body>
    <h1>User List</h1>
    <ul>
        @foreach ($users as $user)
        <li>
            {{ $user->name }} ({{ $user->email }})
            <a href="{{ route('userProfile', ['id' => $user->id]) }}">View Profile</a>
        </li>
        @endforeach
    </ul>
</body>

</html>