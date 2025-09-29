<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin LMS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-indigo-600 p-4 text-white shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Admin LMS</h1>
            <ul class="flex space-x-4">
                <li><a href="{{ route('admin-lms.classes') }}" class="hover:underline">Classes</a></li>
                <li><a href="{{ route('admin-lms.homework') }}" class="hover:underline">Homework</a></li>
            </ul>
        </div>
    </nav>

    <div class="flex flex-1 max-w-7xl mx-auto w-full mt-6">
        <main class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-6">@yield('page-title')</h2>
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>

</body>
</html>
