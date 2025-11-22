@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold">
        {{ __('Student Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-10 max-w-5xl mx-auto">
        <h3 class="text-lg font-bold mb-4">
            Welcome, {{ $user->name }} 🎓
        </h3>

        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="font-semibold text-lg mb-4">Your Courses</h4>

            @forelse ($courses as $course)
                <div class="border rounded-lg p-4 mb-4">
                    <h5 class="font-bold text-gray-800">{{ $course->title }}</h5>
                    <p class="text-sm text-gray-600 mb-2">{{ $course->description }}</p>

                    <div>
                        <span class="text-sm font-medium">Progress:</span>
                        <div class="w-full bg-gray-200 rounded-full h-4 mt-1">
                            <div class="h-4 bg-indigo-500 rounded-full"
                                style="width: {{ $courseProgress[$course->id] }}%">
                            </div>
                        </div>
                        <p class="text-sm mt-1 text-gray-700">
                            {{ $courseProgress[$course->id] }}%
                        </p>
                    </div>

                    <a href="{{ route('courses.show', $course->id) }}"
                        class="mt-3 inline-block text-indigo-600 font-medium">
                        → Go to Course
                    </a>
                </div>
            @empty
                <p class="text-gray-500">You haven't enrolled in any courses yet.</p>
            @endforelse
        </div>
    </div>
@endsection