{{-- resources/views/courses/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Course List</h3>

                @if (in_array($user->role, ['admin', 'teacher']))
                    <a href="{{ route('courses.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md">
                        + New Course
                    </a>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-left text-sm text-gray-700">
                    <thead class="border-b bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Teacher</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Start</th>
                            <th class="px-4 py-2">End</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $course->title }}</td>
                                <td class="px-4 py-2">
                                    {{ $course->teacher?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded text-xs
                                        {{ $course->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $course->start_date }}</td>
                                <td class="px-4 py-2">{{ $course->end_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    No courses found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
