<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center bg-white shadow-md p-4 rounded-lg">
            <h2 class="text-2xl font-semibold">Admin Dashboard</h2>

            <div class="space-x-2">
                @if(auth()->user()->roles->contains('name', 'Admin'))
                    <a href="{{ route('admin.create') }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Create Admin</a>
                @endif

                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Logout</button>
                </form>
            </div>
        </div>

        <!-- User List Section -->
        <div class="mt-6 bg-white shadow-md p-6 rounded-lg">
            <h3 class="text-xl font-semibold mb-4">User List</h3>

            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Role</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border border-gray-300 hover:bg-gray-100">
                            <td class="px-4 py-2 text-center">{{ $user->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-center">{{ $user->email }}</td>
                            <td class="px-4 py-2 text-center">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-1 bg-blue-500 text-white rounded">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 text-center">
                                @if(auth()->user()->roles->contains('name', 'Admin') || auth()->user()->roles->contains('name', 'Editor'))
                                    <a href="{{ route('admin.edit', $user->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
