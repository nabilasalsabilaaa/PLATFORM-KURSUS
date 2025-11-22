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
                {{ $categoryId == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>

    <button type="submit" style="padding: 5px 10px;">
        Filter
    </button>
</form>

<table border="1" cellpadding="6" cellspacing="0" style="width: 100%;">
    <tr>
        <th>Course</th>
        <th>Teacher</th>
        <th>Category</th>
        <th>Actions</th>
    </tr>

    @forelse ($courses as $course)
        <tr>
            <td>{{ $course->title }}</td>
            <td>{{ $course->teacher->name }}</td>
            <td>{{ $course->category->name ?? '-' }}</td>
            <td>
                <a href="mailto:{{ $course->teacher->email }}">Hubungi Teacher</a>

                @auth
                    @if (Auth::user()->role === 'student')
                        <form action="{{ route('courses.enroll', $course->id) }}" 
                            method="POST" style="display:inline;">
                            @csrf
                            <button>Follow Course</button>
                        </form>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}">Login to join</a>
                @endguest
            </td>
        </tr>
    @empty
        <tr><td colspan="4">No courses found.</td></tr>
    @endforelse
</table>

<div style="margin-top: 15px;">
    {{ $courses->links() }}
</div>
@endsection
