@extends('layouts.app')

@section('content')
    <h1>Welcome to Bwakekoqq Platform</h1>

    <p>Temukan kursus yang sesuai dengan minatmu.</p>
    <form method="GET" action="{{ route('home') }}" style="margin: 15px 0;">
        <input
            type="text"
            name="search"
            placeholder="Search courses..."
            value="{{ $search }}"
            style="padding: 5px; width: 200px;"
        >

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

    <h2>Top 5 Popular Courses</h2>

    @if ($courses->isEmpty())
        <p>Belum ada course yang tersedia.</p>
    @else
        <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; margin-top:10px;">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Teacher</th>
                    <th>Category</th>
                    <th>Students</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->teacher->name ?? '-' }}</td>
                        <td>{{ $course->category->name ?? '-' }}</td>
                        <td>{{ $course->students_count }}</td>
                        <td>
                            <a href="{{ route('courses.catalog') }}">View in Catalog</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
