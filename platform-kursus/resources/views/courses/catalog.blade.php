@extends('layouts.app')

@section('title', 'Course Catalog - Chills Kursus')

@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Course Catalog</h1>
        <p class="text-gray-600">Cari dan ikuti kursus yang sesuai sama minat kamu</p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('courses.catalog') }}" class="space-y-4 md:space-y-0 md:flex md:space-x-4 md:items-end">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Courses</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                            name="search" 
                            id="search"
                            placeholder="Search by course title, description..."
                            value="{{ $search }}"
                            class="block w-full pl-10 pr-3 py-2 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300">
                </div>
            </div>

            <div class="flex-1">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Filter by Category</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select name="category" 
                            id="category"
                            class="block w-full pl-10 pr-10 py-2 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 appearance-none bg-white">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            </div>

            <div class="md:flex-shrink-0">
                @if($search || $categoryId)
                    <a href="{{ route('courses.catalog') }}" 
                    class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-lg text-sm font-medium transition duration-300">
                        <i class="fas fa-times mr-2"></i> 
                        Clear filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="flex justify-between items-center mb-4">
        <p class="text-gray-600">
            Showing {{ $courses->count() }} of {{ $courses->total() }} courses
        </p>
    </div>

    @if($courses->isEmpty())
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-900 mb-2">No courses found</h3>
            <p class="text-gray-600 mb-6">Coba ganti kata kunci atau ganti filternya...</p>
            <a href="{{ route('courses.catalog') }}" 
                class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg transition duration-300">
                Browse All Courses
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach ($courses as $course)
                @php
                    $isStudent   = auth()->check() && auth()->user()->role === 'student';
                    $isEnrolled  = $isStudent && in_array($course->id, $enrolledCourseIds ?? []);
                    $progress    = $isStudent ? ($courseProgress[$course->id] ?? 0) : null;
                @endphp
                
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <div class="h-4 bg-gradient-to-r from-primary-500 to-secondary-500"></div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-secondary-100 text-secondary-800">
                                {{ $course->category->name ?? 'Uncategorized' }}
                            </span>
                            <span class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i> {{ $course->students_count }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">{{ $course->title }}</h3>
                        
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3">
                                {{ substr($course->teacher->name ?? 'T', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $course->teacher->name ?? 'No Teacher' }}</p>
                                <p class="text-xs text-gray-500">Instructor</p>
                            </div>
                        </div>

                        @auth
                            @if(Auth::user()->role === 'student' && $isEnrolled)
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Your Progress</span>
                                        <span>{{ $progress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        <div class="space-y-3">
                            @if($course->teacher && $course->teacher->email)
                                <a href="mailto:{{ $course->teacher->email }}" 
                                    class="w-full flex items-center justify-center px-4 py-2 border border-primary-500 text-primary-500 rounded-lg hover:bg-primary-50 transition duration-300">
                                    <i class="fas fa-envelope mr-2"></i> Contact Teacher
                                </a>
                            @endif

                            @auth
                                @if(Auth::user()->role === 'student')
                                    @if($isEnrolled)
                                        <form action="{{ route('courses.unenroll', $course->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-full flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition duration-300">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Unenroll
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full flex items-center justify-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg transition duration-300">
                                                <i class="fas fa-plus mr-2"></i> Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @endauth

                            <a href="{{ route('courses.show', $course->id) }}" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-300">
                                <i class="fas fa-eye mr-2"></i> View Details
                            </a>

                            @guest
                                <div class="text-center">
                                    <a href="{{ route('login') }}" 
                                        class="text-primary-500 hover:text-primary-600 text-sm flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt mr-1"></i> Login to enroll
                                    </a>
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($courses->hasPages())
        <div class="bg-white rounded-xl shadow-md px-6 py-4">
            {{ $courses->links() }}
        </div>
    @endif

    @guest
        <div class="mt-8 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-xl p-8 text-center text-white">
            <h2 class="text-2xl font-bold mb-4">Gimana? Ready to Start Learning?</h2>
            <p class="mb-6 opacity-90">Ayo bergabung dan belajar bersama jutaan pelajar di Chills Kursus</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" 
                    class="bg-white text-primary-500 hover:bg-gray-100 px-6 py-3 rounded-lg font-medium transition duration-300">
                    Sign Up
                </a>
                <a href="{{ route('login') }}" 
                    class="border border-white text-white hover:bg-white hover:bg-opacity-10 px-6 py-3 rounded-lg font-medium transition duration-300">
                    Login to Account
                </a>
            </div>
        </div>
    @endguest
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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const categorySelect = document.getElementById('category');

        categorySelect.addEventListener('change', function() {
            if(this.value) {
                this.form.submit();
            }
        });

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });

        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if(submitButton) {
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Loading...';
                    submitButton.disabled = true;
                }
            });
        });
    });
</script>
@endsection