<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
  <div class="h-screen flex overflow-hidden">

    <!-- Sidebar -->

    <!-- <div id="sidebar"
         class="bg-white shadow-lg transition-all duration-300
                w-64 lg:relative lg:translate-x-0 lg:flex-shrink-0
                fixed inset-y-0 left-0 transform -translate-x-full lg:transform-none z-50 overflow-hidden">
      <div class="p-4 border-b flex justify-between items-center">
        <h1 class="font-bold">{{ config('app.name', 'LMS') }}</h1>

        <button class="lg:hidden text-gray-600" onclick="toggleSidebar()">✖</button>
      </div>
      <nav class="mt-4">
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-200">Dashboard</a>
        <a href="{{ route('attendance') }}" class="block px-4 py-2 hover:bg-gray-200">Attendance</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Reports</a>
         <a href="#" class="block px-4 py-2 hover:bg-gray-200">Lms</a>
        <a href="#" class="block px-4 py-2 hover:bg-gray-200">Settings</a>
      </nav>
    </div> -->

    <x-test.sidebar />

    <!-- Main wrapper -->
    <div id="mainContent" class="flex-1 flex flex-col transition-all duration-300">
      <!-- Navbar -->
      <x-test.navbar />

      <!-- Alpine.js (for dropdown toggle) -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>

      <!-- Page Content -->
      <main class="flex-1 overflow-auto">
        <div class="p-6">
          {{ $slot }}
        </div>
      </main>
    </div>
  </div>

  <style>
    .swal-progress-bar {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: #facc15;
      /* Yellow */
      animation: progressFade 6s linear forwards;
      border-bottom-left-radius: 8px;
      /* Match toast border radius */
      border-bottom-right-radius: 8px;
    }

    @keyframes progressFade {
      from {
        width: 100%;
      }

      to {
        width: 0%;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function showToast(type, title, background, iconColor, progressBarColor) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: type,
          title: title,
          showConfirmButton: false,
          showCloseButton: true,
          timer: 6000,
          timerProgressBar: true,
          background: background,
          color: '#333', // Dark text for better readability
          iconColor: iconColor,
          showClass: {
            popup: 'animate__animated animate__fadeInRight'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutRight'
          },
          customClass: {
            popup: 'custom-toast'
          },
          didRender: () => {
            const swalPopup = document.querySelector('.swal2-popup');
            if (swalPopup) {
              const progressBar = document.createElement('div');
              progressBar.classList.add('swal-progress-bar');
              progressBar.style.background = progressBarColor; // Set progress bar color
              swalPopup.appendChild(progressBar);
            }
          }
        });
      }

      // Example of session data embedded in the HTML
      const sessionData = {
        success: "{{ session('success') }}",
        error: "{{ session('error') }}",
        warning: "{{ session('warning') }}",
        updated: "{{ session('updated') }}",
        deleted: "{{ session('deleted') }}"
      };

      if (sessionData.success) {
        showToast('success', `🎉 ${sessionData.success}`, '#d1fae5', '#047857', '#6ee7b7');
      }

      if (sessionData.error) {
        showToast('error', `❌ ${sessionData.error}`, '#fee2e2', '#dc2626', '#f87171');
      }

      if (sessionData.warning) {
        showToast('warning', `⚠️ ${sessionData.warning}`, '#fef9c3', '#b45309', '#facc15');
      }

      if (sessionData.updated) {
        showToast('info', `✏️ ${sessionData.updated}`, '#dbeafe', '#1e40af', '#93c5fd');
      }

      if (sessionData.deleted) {
        showToast('error', `🗑️ ${sessionData.deleted}`, '#fde2e4', '#9b2226', '#ff6b6b');
      }
    });
  </script>

  <script>
    // General confirmation function for delete actions
    function confirmDelete(formId) {
      Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById(formId).submit();
        }
      });
    }
  </script>

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


  @include('sweetalert::alert')


</body>

</html>