@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-bold">
        {{ $course->title }}
    </h2>
@endsection

@section('content')
    <div class="py-8 max-w-5xl mx-auto space-y-6">

        <div class="bg-white shadow rounded p-6">
            <p><strong>Teacher:</strong> {{ $course->teacher->name ?? '-' }}</p>
            <p><strong>Category:</strong> {{ $course->category->name ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($course->status) }}</p>
            <p><strong>Duration:</strong>
                {{ $course->start_date }} – {{ $course->end_date }}
            </p>
            <p><strong>Total Lessons:</strong> {{ $totalLessons }}</p>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-2">Description</h3>
            <p class="text-gray-700">
                {!! nl2br(e($course->description)) !!}
            </p>
        </div>

        <div class="bg-white shadow rounded p-6">
            @auth
                @if ($isStudent)
                    @if ($isEnrolled)
                        <p class="mb-2">
                            You are enrolled in this course.
                        </p>
                        <p class="mb-4">
                            Progress: <strong>{{ $completedCount }} / {{ $totalLessons }}</strong>
                            ({{ $progress }}%)
                        </p>

                        <form action="{{ route('courses.unenroll', $course->id) }}"
                                method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded text-sm">
                                Unenroll
                            </button>
                        </form>

                        @php
                            $firstLesson = $course->contents->first();
                        @endphp

                        @if ($firstLesson)
                            <a href="{{ route('lessons.show', [$course->id, $firstLesson->id]) }}"
                                class="ml-2 px-3 py-1 bg-indigo-600 text-white rounded text-sm inline-block">
                                Continue Learning
                            </a>
                        @endif

                    @else
                        <p class="mb-3">
                            You are not enrolled in this course yet.
                        </p>

                        <form action="{{ route('courses.enroll', $course->id) }}"
                                method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded">
                                Enroll Now
                            </button>
                        </form>
                    @endif
                @else
                    <p>
                        You are logged in as <strong>{{ auth()->user()->role }}</strong>.
                    </p>
                @endif
            @endauth

            @guest
                <p class="mb-3">
                    Login atau daftar untuk mengikuti course ini.
                </p>
                <a href="{{ route('login') }}" class="underline mr-3">Login</a>
                <a href="{{ route('register') }}" class="underline">Register</a>
            @endguest
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-3">Lessons</h3>

            @if ($course->contents->isEmpty())
                <p class="text-gray-500">Belum ada lesson di course ini.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($course->contents as $idx => $content)
                        <li class="flex justify-between items-center border-b pb-1">
                            <span>
                                {{ $idx + 1 }}. {{ $content->title }}
                            </span>

                            @auth
                                @if ($isStudent && $isEnrolled)
                                    <a href="{{ route('lessons.show', [$course->id, $content->id]) }}"
                                        class="text-sm text-indigo-600 underline">
                                        View
                                    </a>
                                @endif
                            @endauth
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
