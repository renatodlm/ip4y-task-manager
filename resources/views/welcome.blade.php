<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IP4Y Task Manager</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="antialiased bg-gray-100 dark:bg-gray-900">

    <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-800 dark:to-gray-900">
        <div class="text-center">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">IP4Y Task Manager</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">Manage your tasks efficiently with IP4Y Task Manager</p>

            <div class="space-x-4">
                @auth
                <a href="{{ url('/dashboard') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Dashboard</a>
                @else
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Login</a>
                <a href="{{ route('register') }}"
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Register</a>
                @endauth
            </div>
        </div>
    </div>

</body>

</html>
