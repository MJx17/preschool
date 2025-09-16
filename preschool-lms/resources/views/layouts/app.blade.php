<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
  <div class="h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <div id="sidebar"
         class="bg-white shadow-lg transition-all duration-300
                w-64 lg:relative lg:translate-x-0 lg:flex-shrink-0
                fixed inset-y-0 left-0 transform -translate-x-full lg:transform-none z-50 overflow-hidden">
      <div class="p-4 border-b flex justify-between items-center">
        <h1 class="font-bold">{{ config('app.name', 'LMS') }}</h1>
        <!-- Close button only on mobile -->
        <button class="lg:hidden text-gray-600" onclick="toggleSidebar()">✖</button>
      </div>
      <nav class="mt-4">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">Dashboard</a>
        <a href="{{ route('attendance') }}" class="block px-4 py-2 hover:bg-gray-200">Attendance</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Reports</a>
         <a href="#" class="block px-4 py-2 hover:bg-gray-200">Lms</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Settings</a>
      </nav>
    </div>

    <!-- Main wrapper -->
    <div id="mainContent" class="flex-1 flex flex-col transition-all duration-300">
      <!-- Navbar -->
      <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <!-- Burger always visible -->
          <button class="text-gray-600 hover:text-gray-900" onclick="toggleSidebar()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h2 class="text-lg font-semibold">{{ $header ?? 'Dashboard' }}</h2>
        </div>
        <div>
          @auth
            {{ Auth::user()->name }}
          @else
            Guest
          @endauth
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-auto">
        <div class="p-6">
          {{ $slot }}
        </div>
      </main>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");

      if (window.innerWidth >= 1024) {
        // Desktop: collapse/expand
        if (sidebar.classList.contains("w-64")) {
          sidebar.classList.remove("w-64");
          sidebar.classList.add("w-0");
        } else {
          sidebar.classList.remove("w-0");
          sidebar.classList.add("w-64");
        }
      } else {
        // Mobile: overlay slide
        sidebar.classList.toggle("-translate-x-full");
      }
    }
  </script>
</body>
</html>
