@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
        {{ __('Teacher Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-10 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <h3 class="text-lg font-bold mb-4">
            Welcome, {{ $user->name }} 👩‍🏫
        </h3>

        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="font-semibold text-lg mb-4">
                Courses you teach
            </h4>

            @forelse ($courses as $course)
                <div class="border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h5 class="font-bold text-gray-800">
                                {{ $course->title }}
                            </h5>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $course->description }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Status:
                                <span class="font-semibold">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </p>
                        </div>

                        <div class="text-right text-sm text-gray-700">
                            <p>Students: <span class="font-bold">{{ $course->students_count }}</span></p>
                            <p>Lessons: <span class="font-bold">{{ $course->contents_count }}</span></p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <a href="{{ route('contents.index', $course) }}"
                            class="text-xs px-3 py-1 rounded bg-indigo-100 text-indigo-800">
                            Manage Contents
                        </a>

                        @if (Route::has('courses.show'))
                            <a href="{{ route('courses.show', $course) }}"
                                class="text-xs px-3 py-1 rounded bg-gray-100 text-gray-800">
                                View Course
                            </a>
                        @endif

                        <a href="{{ route('teacher.courses.students', $course->id) }}"
                        class="text-xs px-3 py-1 rounded bg-green-100 text-green-800">
                            Student Progress
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">
                    You are not teaching any courses yet.
                </p>
            @endforelse
        </div>
    </div>
@endsection
