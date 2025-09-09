@props(['title' => ''])

<div class="bg-white p-6 rounded-lg shadow h-full flex flex-col">
    <!-- Title -->
    <h3 class="text-lg font-semibold mb-4">{{ $title }}</h3>
    
    <!-- Table wrapper -->
    <div class="overflow-x-auto flex-1 p-2">
        {{ $slot }}
    </div>
</div>
