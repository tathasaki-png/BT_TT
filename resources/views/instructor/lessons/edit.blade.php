@extends('layouts.app')

@section('content')
    <h3>Edit Lesson for: {{ $course->title }}</h3>

    <form method="POST" action="{{ route('instructor.courses.lessons.update', [$course, $lesson]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="{{ old('title', $lesson->title) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Video</label>
            @if($lesson->video_path)
                <div class="mb-2"><a href="{{ asset('storage/' . $lesson->video_path) }}" target="_blank">View current video</a></div>
            @endif
            <label class="form-label">Replace Video (optional)</label>
            <input type="file" name="video" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('instructor.courses.lessons.index', $course) }}" class="btn btn-link">Cancel</a>
    </form>
@endsection
