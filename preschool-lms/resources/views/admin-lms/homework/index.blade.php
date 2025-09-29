@extends('admin-lms.layouts.admin')

@section('title', 'Homework')
@section('page-title', '✏️ Homework')

@section('content')
    <a href="{{ route('admin-lms.homework.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Homework</a>

    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-indigo-100 text-indigo-800">
            <tr>
                <th class="py-3 px-4">ID</th>
                <th class="py-3 px-4">Class</th>
                <th class="py-3 px-4">Title</th>
                <th class="py-3 px-4">Due</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($homework as $hw)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $hw->id }}</td>
                    <td class="py-3 px-4">{{ $classes->firstWhere('id', $hw->class_id)->name ?? 'Unknown' }}</td>
                    <td class="py-3 px-4">{{ $hw->title }}</td>
                    <td class="py-3 px-4">{{ $hw->due }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
