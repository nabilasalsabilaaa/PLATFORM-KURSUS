@extends('layouts.app')

@section('title', 'Courses - Bwakekoqq Platform')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Courses') }}</h2>
            <p class="text-gray-600 mt-1">Manage and view all courses in the platform</p>
        </div>
        @if (in_array($user->role, ['admin', 'teacher']))
            <a href="{{ route('courses.create') }}"
                class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i> New Course
            </a>
        @endif
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-secondary-50 border-l-4 border-secondary-500 text-secondary-700 p-4 mb-6 rounded" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <i class="fas fa-check-circle text-secondary-500 mr-3"></i>
                    </div>
                    <div>
                        <p class="font-medium">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary-50 text-primary-500 mr-4">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Courses</p>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $courses->total() }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-50 text-green-500 mr-4">
                        <i class="fas fa-play-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Courses</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $courses->where('status', 'active')->count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-50 text-orange-500 mr-4">
                        <i class="fas fa-pause-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Inactive Courses</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $courses->where('status', 'inactive')->count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-50 text-blue-500 mr-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Students</p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $courses->sum('students_count') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-100">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Course
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teacher
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Students
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lessons
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dates
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-100">
                        @forelse ($courses as $course)
                            <tr class="hover:bg-primary-50 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center text-white">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $course->title }}</div>
                                            <div class="text-sm text-gray-500 line-clamp-1">
                                                {{ Str::limit($course->description, 50) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center text-white text-xs font-bold">
                                                {{ substr($course->teacher?->name ?? 'T', 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $course->teacher?->name ?? 'No Teacher' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                        {{ $course->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $course->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        <span class="w-2 h-2 rounded-full mr-1 
                                            {{ $course->status === 'active' ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>
                                        {{ $course->students_count }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <i class="fas fa-layer-group mr-2 text-gray-400"></i>
                                        {{ $course->contents_count }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span class="font-medium">
                                            Start: {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('M d, Y') : 'N/A' }}
                                        </span>
                                        <span>
                                            End: {{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('courses.show', $course) }}" 
                                            class="text-primary-500 hover:text-primary-700 transition duration-300"
                                            title="View Course">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if (in_array($user->role, ['admin', 'teacher']) && ($user->role === 'admin' || $course->teacher_id === $user->id))
                                            <a href="{{ route('contents.index', $course) }}"
                                                class="text-indigo-500 hover:text-indigo-700 transition duration-300"
                                                title="Manage Contents">
                                                <i class="fas fa-layer-group"></i>
                                            </a>
                                        @endif
                                        @if (in_array($user->role, ['admin', 'teacher']) && ($user->role === 'admin' || $course->teacher_id === $user->id))
                                            <a href="{{ route('courses.edit', $course) }}" 
                                                class="text-secondary-500 hover:text-secondary-700 transition duration-300"
                                                title="Edit Course">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if (in_array($user->role, ['admin', 'teacher']) && ($user->role === 'admin' || $course->teacher_id === $user->id))
                                            <a href="{{ route('teacher.courses.students', $course->id) }}"
                                                class="text-green-500 hover:text-green-700 transition duration-300"
                                                title="Student Progress">
                                                <i class="fas fa-chart-line"></i>
                                            </a>
                                        @endif
                                        @if ($user->role === 'admin' || ($user->role === 'teacher' && $course->teacher_id === $user->id))
                                            <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.')"
                                                        class="text-red-500 hover:text-red-700 transition duration-300"
                                                        title="Delete Course">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No courses found</h3>
                                        <p class="text-gray-500 mb-4">Get started by creating your first course.</p>
                                        @if (in_array($user->role, ['admin', 'teacher']))
                                            <a href="{{ route('courses.create') }}" 
                                                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition duration-300">
                                                Create First Course
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($courses->hasPages())
                <div class="bg-white px-6 py-4 border-t border-neutral-100">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
        @if (in_array($user->role, ['admin', 'teacher']))
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('courses.create') }}" 
                class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300 border-l-4 border-primary-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-primary-50 text-primary-500 mr-4">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Create New Course</h3>
                        <p class="text-sm text-gray-600">Add a new course to the platform</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('courses.catalog') }}" 
                class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300 border-l-4 border-secondary-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-secondary-50 text-secondary-500 mr-4">
                        <i class="fas fa-list"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">View Public Catalog</h3>
                        <p class="text-sm text-gray-600">See how courses appear to students</p>
                    </div>
                </div>
            </a>

            @if($user->role === 'admin')
            <a href="{{ route('categories.index') }}" 
                class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition duration-300 border-l-4 border-orange-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-orange-50 text-orange-500 mr-4">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-800">Manage Categories</h3>
                        <p class="text-sm text-gray-600">Organize courses by categories</p>
                    </div>
                </div>
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }
    
    .pagination li {
        margin: 0 2px;
    }
    
    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #e4e6ee;
        border-radius: 6px;
        color: #4B5563;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .pagination li a:hover {
        background-color: #e8e4fb;
        border-color: #716bf0;
        color: #716bf0;
    }
    
    .pagination li.active span {
        background-color: #716bf0;
        border-color: #716bf0;
        color: white;
    }
    
    .pagination li.disabled span {
        color: #9CA3AF;
        background-color: #F3F4F6;
        border-color: #E5E7EB;
    }

    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelectorAll('a[href*="edit"], a[href*="show"]');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            });
        });
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const titleEl = this.closest('tr').querySelector('td:first-child .text-sm.font-medium.text-gray-900');
                const courseTitle = titleEl ? titleEl.textContent.trim() : 'this course';
                const studentText = this.closest('tr').querySelector('.fa-users').parentElement.textContent.trim();
                const studentCount = parseInt(studentText) || 0;
                
                let message = `Are you sure you want to delete "${courseTitle}"?`;
                if (studentCount > 0) {
                    message += ` This course has ${studentCount} enrolled student(s) that will be affected.`;
                }
                message += ' This action cannot be undone.';
                
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });

        function refreshStats() {
            console.log('Refreshing course statistics...');
        }
    });
</script>
@endsection
