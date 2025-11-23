@extends('layouts.app')

@section('content')
    <h1>Welcome to Bwakekoqq Platform</h1>

    <div style="margin: 8px 0 16px 0;">
        @auth
            <p style="margin-bottom: 6px;">
                You are logged in as <strong>{{ Auth::user()->name }}</strong>
                (role: <strong>{{ Auth::user()->role }}</strong>).
            </p>
            <a href="{{ route('dashboard') }}" style="padding: 6px 10px; border: 1px solid #333; text-decoration:none;">
                Go to Dashboard
            </a>
        @endauth

        @guest
            <p style="margin-bottom: 6px;">
                Login atau daftar untuk mulai mengikuti course.
            </p>
            <a href="{{ route('login') }}" style="margin-right: 8px; text-decoration:none;">
                Login
            </a>
            <a href="{{ route('register') }}" style="text-decoration:none;">
                Register
            </a>
        @endguest
    </div>

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
                            <a href="{{ route('courses.detail', $course->id) }}">View Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p style="margin-top: 12px;">
        <a href="{{ route('courses.catalog') }}">Lihat semua course →</a>
    </p>
@endsection
