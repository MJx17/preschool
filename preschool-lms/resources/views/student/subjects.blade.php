<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Subjects
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-6 px-4">
        @if($subjects->isEmpty())
            <p class="text-gray-600">No subjects assigned yet.</p>
        @else
            <ul class="space-y-2">
                @foreach($subjects as $subject)
                    <li class="p-4 bg-white rounded-lg shadow-sm">
                        {{ $subject->name }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
