@extends('admin-lms.layouts.admin')

@section('title', 'Lessons')
@section('page-title', '📖 Lessons')

@section('content')
    <a href="{{ route('admin-lms.lessons.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Lesson</a>

    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-indigo-100 text-indigo-800">
            <tr>
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Title</th>
                <th class="py-3 px-4 text-left">Class</th>
                <th class="py-3 px-4 text-left">File</th>
                <th class="py-3 px-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lessons as $lesson)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $lesson->id }}</td>
                    <td class="py-3 px-4">{{ $lesson->title }}</td>
                    <td class="py-3 px-4">{{ $classes->firstWhere('id', $lesson->class_id)->name ?? 'N/A' }}</td>
                    <td class="py-3 px-4">{{ $lesson->file }}</td>
                    <td class="py-3 px-4 space-x-2">
                        <a href="{{ route('admin-lms.lessons.edit', $lesson->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
