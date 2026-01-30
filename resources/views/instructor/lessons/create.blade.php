@extends('layouts.app')

@section('content')
    <h3>Create Lesson for: {{ $course->title }}</h3>

    <form method="POST" action="{{ route('instructor.courses.lessons.store', $course) }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Video File</label>
            <input type="file" name="video" class="form-control" required>
        </div>

        <button class="btn btn-primary">Create</button>
        <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="btn btn-link">Cancel</a>
    </form>
@endsection
