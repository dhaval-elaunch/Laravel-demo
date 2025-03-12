<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Admin User</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-center mb-4">Edit Admin User</h2>

        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-200 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('POST')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Name:</label>
                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $admin->name }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email:</label>
                <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $admin->email }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Role:</label>
                <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ $admin->roles->contains($role->id) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">Update</button>
        </form>
    </div>

</body>

</html>
