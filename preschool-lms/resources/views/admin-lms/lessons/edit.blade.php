@extends('admin-lms.layouts.admin')

@section('title', 'Edit Lesson')
@section('page-title', '✏️ Edit Lesson')

@section('content')
<form action="{{ route('admin-lms.lessons.update', $lesson->id) }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block font-medium text-gray-700">Title</label>
        <input type="text" name="title" value="{{ $lesson->title }}" class="w-full border p-2 rounded" required>
    </div>

    <div>
        <label class="block font-medium text-gray-700">Class</label>
        <select name="class_id" class="w-full border p-2 rounded" required>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" @if($lesson->class_id == $class->id) selected @endif>{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-medium text-gray-700">File (PDF/PPT)</label>
        <input type="text" name="file" value="{{ $lesson->file }}" class="w-full border p-2 rounded" required>
    </div>

    <div id="quiz-section">
        <h3 class="font-semibold mb-2">Quiz</h3>
        @foreach ($lesson->quiz as $index => $q)
        <div class="quiz-item mb-2">
            <input type="text" name="quiz[{{ $index }}][question]" value=
