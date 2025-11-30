@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">
        Students Progress for: <span class="text-primary-600">{{ $course->title }}</span>
    </h1>
    <p class="text-gray-700 text-sm mb-1">
        <strong>Teacher:</strong> {{ $course->teacher->name }}
    </p>
    <p class="text-gray-700 text-sm mb-6">
        <strong>Total lessons:</strong> {{ $totalLessons }}
    </p>
    @if (count($studentProgress) === 0)
        <div class="bg-white rounded-2xl p-8 shadow-md text-center">
            <i class="fas fa-user-slash text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-600 font-medium">No students enrolled in this course yet.</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-primary-500 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Student Name</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-center">Completed Lessons</th>
                        <th class="py-3 px-4 text-center">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentProgress as $item)
                        <tr class="border-b hover:bg-primary-50/40 transition">
                            <td class="py-3 px-4">{{ $item['student']->name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $item['student']->email }}</td>
                            <td class="py-3 px-4 text-center font-medium">
                                {{ $item['completed'] }} / {{ $item['total_lessons'] }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $item['progress'] }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="mt-6">
        <a href="{{ route('courses.index') }}"
            class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to My Courses
        </a>
    </div>

</div>
@endsection
