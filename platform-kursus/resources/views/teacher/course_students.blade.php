@extends('layouts.app')

@section('content')
    <h1>Students Progress for: {{ $course->title }}</h1>

    <p>Teacher: {{ $course->teacher->name }}</p>
    <p>Total lessons: {{ $totalLessons }}</p>

    @if (count($studentProgress) === 0)
        <p>No students enrolled in this course yet.</p>
    @else
        <table border="1" cellpadding="6" cellspacing="0" style="margin-top: 10px; width: 100%;">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Completed Lessons</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($studentProgress as $item)
                    <tr>
                        <td>{{ $item['student']->name }}</td>
                        <td>{{ $item['student']->email }}</td>
                        <td>{{ $item['completed'] }} / {{ $item['total_lessons'] }}</td>
                        <td>{{ $item['progress'] }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p style="margin-top: 15px;">
        <a href="{{ route('profile.teacher') }}">← Back to Teacher Dashboard</a>
    </p>
@endsection
