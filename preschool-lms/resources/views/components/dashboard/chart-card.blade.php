@props([
    'title' => 'Chart',
    'id' => 'chartCanvas',
    'type' => 'bar', // default chart type
    'labels' => [],
    'datasets' => []
])

<div class="bg-white p-6 rounded-lg shadow h-96 flex flex-col pb-20">
    <h3 class="text-lg font-semibold mb-4 text-center">{{ $title }}</h3>
    <canvas
        id="{{ $id }}"
        data-type="{{ $type }}"
        data-labels='@json($labels)'
        data-datasets='@json($datasets)'
        class="flex-1 w-full h-full"
    ></canvas>
</div>
