@props([
    'title' => 'Chart',
    'id' => 'chartContainer',
    'type' => 'bar', // 'bar', 'line', 'doughnut', etc.
    'labels' => [],   // Array of labels
    'datasets' => []  // Array of datasets for Chart.js
])

<div class="bg-white p-6 rounded-lg shadow h-96 flex flex-col">
    <h3 class="text-lg font-semibold mb-4 text-center">{{ $title }}</h3>
    <canvas 
        id="{{ $id }}" 
        data-type="{{ $type }}" 
        data-labels='@json($labels)' 
        data-datasets='@json($datasets)' 
        class="flex-1 w-full h-full">
    </canvas>
</div>
