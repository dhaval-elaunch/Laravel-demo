<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}</h1>
    <p>Your Role: {{ $user->roles->first()->name }}</p>

    @if($user->hasRole('Admin'))
        <p>You have admin privileges.</p>
    @elseif($user->hasRole('Editor'))
        <p>You have editor privileges.</p>
    @else
        <p>You are a regular user.</p>
    @endif
</body>
</html>
