<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Admin Login</h2>

        <!-- Display Errors -->
        @if ($errors->any())
            <div class="mt-4 p-3 bg-red-100 text-red-600 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login') }}" class="mt-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Enter your email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" placeholder="Enter your password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                Login
            </button>
        </form>
    </div>

</body>

</html>
