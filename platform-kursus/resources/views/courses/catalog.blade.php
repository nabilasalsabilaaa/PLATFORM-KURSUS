<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Catalog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">All Active Courses</h3>

                @forelse ($courses as $course)
                    <div class="border-b py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h4 class="font-semibold text-gray-800">
                                {{ $course->title }}
                            </h4>
                            <p class="text-sm text-gray-600">
                                Teacher:
                                {{ $course->teacher?->name ?? '-' }}
                                ({{ $course->teacher?->email ?? 'no email' }})
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ \Illuminate\Support\Str::limit($course->description, 100) }}
                            </p>
                        </div>

                        <div class="flex flex-col items-start sm:items-end gap-2">
                            {{-- Tombol hubungi teacher --}}
                            @if ($course->teacher?->email)
                                <a href="mailto:{{ $course->teacher->email }}"
                                   class="px-3 py-1 text-xs rounded bg-gray-100 text-gray-800">
                                    Hubungi Teacher
                                </a>
                            @endif

                            {{-- Tombol enroll / unenroll untuk student --}}
                            @php
                                $user = auth()->user();
                                $isStudent = $user && $user->role === 'student';
                                $isEnrolled = $isStudent
                                    ? $user->enrolledCourses->contains($course->id)
                                    : false;
                            @endphp

                            @if ($isStudent)
                                @if ($isEnrolled)
                                    <form action="{{ route('courses.unenroll', $course) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded bg-gray-200 text-gray-800">
                                            Unenroll
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded bg-indigo-600 text-white">
                                            Enroll
                                        </button>
                                    </form>
                                @endif
                            @else
                                {{-- Guest atau role lain --}}
                                <p class="text-xs text-gray-500">
                                    Login sebagai student untuk ikut course.
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">
                        No active courses available.
                    </p>
                @endforelse

                <div class="mt-4">
                    {{ $courses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
