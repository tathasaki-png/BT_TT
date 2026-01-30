@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Lessons for: {{ $course->title }}</h3>
        <a href="{{ route('instructor.courses.lessons.create', $course) }}" class="btn btn-primary">New Lesson</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Position</th>
                <th>Title</th>
                <th>Video</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->position }}</td>
                    <td>{{ $lesson->title }}</td>
                    <td>
                        @if($lesson->video_path)
                            <a href="{{ asset('storage/' . $lesson->video_path) }}" target="_blank">View</a>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('instructor.courses.lessons.edit', [$course, $lesson]) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('instructor.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this lesson?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        <form action="{{ route('instructor.courses.lessons.moveUp', [$course, $lesson]) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary">Up</button>
                        </form>
                        <form action="{{ route('instructor.courses.lessons.moveDown', [$course, $lesson]) }}" method="POST" class="d-inline-block">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary">Down</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
