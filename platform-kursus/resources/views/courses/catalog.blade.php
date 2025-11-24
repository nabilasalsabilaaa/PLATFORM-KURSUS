@extends('layouts.app')

@section('content')
    <h1>Course Catalog</h1>
    <form method="GET" action="{{ route('courses.catalog') }}" style="margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search courses..."
                value="{{ $search }}" style="padding: 5px; width: 200px;">
        <select name="category" style="padding: 5px;">
            <option value="">-- All Categories --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" style="padding: 5px 10px;">
            Filter
        </button>
    </form>
    <table border="1" cellpadding="6" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>Course</th>
                <th>Teacher</th>
                <th>Category</th>
                <th>Students</th>
                @auth
                    @if (Auth::user()->role === 'student')
                        <th>Your Progress</th>
                        <th>Enroll</th>
                    @endif
                @endauth
                <th>Contact</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                @php
                    $isStudent   = auth()->check() && auth()->user()->role === 'student';
                    $isEnrolled  = $isStudent && in_array($course->id, $enrolledCourseIds ?? []);
                    $progress    = $isStudent ? ($courseProgress[$course->id] ?? 0) : null;
                @endphp
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->teacher->name ?? '-' }}</td>
                    <td>{{ $course->category->name ?? '-' }}</td>
                    <td>{{ $course->students_count }}</td>
                    @auth
                        @if (Auth::user()->role === 'student')
                            <td>
                                @if ($isEnrolled)
                                    {{ $progress }}%
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($isEnrolled)
                                    <form action="{{ route('courses.unenroll', $course->id) }}"
                                            method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Unenroll</button>
                                    </form>
                                @else
                                    <form action="{{ route('courses.enroll', $course->id) }}"
                                            method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit">Enroll</button>
                                    </form>
                                @endif
                            </td>
                            @endif
                        @endauth
                        <td>
                            @if ($course->teacher && $course->teacher->email)
                                <a href="mailto:{{ $course->teacher->email }}">
                                    Hubungi Teacher
                                </a>
                            @else
                                -
                            @endif
                            @guest
                                <br>
                                <a href="{{ route('login') }}" style="font-size: 12px;">
                                    Login to join
                                </a>
                            @endguest
                        </td>
                            
                        <td>
                            <a href="{{ route('courses.show', $course->id) }}">
                                View Detail
                            </a>
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No courses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top: 15px;">
        {{ $courses->links() }}
    </div>
@endsection