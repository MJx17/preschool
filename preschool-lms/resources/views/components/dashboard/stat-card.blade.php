@props([
    'title',
    'value',
    'subtitle' => '',
    'color' => 'indigo',
])

@php
    $map = [
        'indigo' => 'bg-indigo-500',
        'green'  => 'bg-green-500',
        'yellow' => 'bg-yellow-500',
        'red'    => 'bg-red-500',
    ];
    $bgClass = $map[$color] ?? 'bg-indigo-500';
@endphp

<div class="p-6 {{ $bgClass }} rounded-xl shadow text-white flex items-center gap-4">
    @if (isset($icon))
        <div class="w-8 h-8">
            {{ $icon }}
        </div>
    @endif
    <div>
        <h3 class="text-sm font-medium">{{ $title }}</h3>
        <p class="text-2xl font-bold">{{ $value }}</p>
        @if ($subtitle)
            <p class="text-xs opacity-80">{{ $subtitle }}</p>
        @endif
    </div>
</div>
