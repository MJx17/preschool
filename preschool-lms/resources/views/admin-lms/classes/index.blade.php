@extends('admin-lms.layouts.admin')

@section('title', 'Classes')
@section('page-title', '📚 Classes')

@section('content')
    <a href="{{ route('admin-lms.classes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Class</a>

    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-indigo-100 text-indigo-800">
            <tr>
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Name</th>
                <th class="py-3 px-4 text-left">Teacher</th>
                <th class="py-3 px-4 text-left">Schedule</th>
                <th class="py-3 px-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $class->id }}</td>
                    <td class="py-3 px-4">{{ $class->name }}</td>
                    <td class="py-3 px-4">{{ $class->teacher }}</td>
                    <td class="py-3 px-4">{{ $class->schedule }}</td>
                    <td class="py-3 px-4 space-x-2">
                        <a href="{{ route('admin-lms.classes.edit', $class->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <!-- Delete form can be added later -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
