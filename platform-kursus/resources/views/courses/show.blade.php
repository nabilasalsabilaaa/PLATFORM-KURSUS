@extends('layouts.app')

@section('title', $course->title . ' - Chills Kursus')

@section('header')

    @php
        $resolvedBackRoute = $backRoute ?? (
            auth()->check() && str_contains(url()->previous(), '/dashboard/courses')
                ? 'courses.index'
                : 'courses.catalog'
        );
    @endphp

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $course->title }}</h2>
            <div class="flex items-center space-x-4 mt-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $course->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    <span class="w-2 h-2 rounded-full mr-2 
                        {{ $course->status === 'active' ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                    {{ ucfirst($course->status) }}
                </span>
                <span class="text-gray-600 flex items-center">
                    <i class="fas fa-users mr-1"></i> {{ $course->students_count }} students
                </span>
            </div>
        </div>

        <a href="{{ route($resolvedBackRoute) }}" 
            class="inline-flex items-center bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-soft-card transition-all duration-300 hover:-translate-y-0.5">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ $resolvedBackRoute === 'courses.index' ? 'Back to Dashboard Courses' : 'Back to Catalog' }}
        </a>
    </div>
@endsection

@section('content')
<div class="py-8 max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Course Overview</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-primary-500 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Instructor</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $course->teacher->name ?? 'No Teacher' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-secondary-500 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-tag"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Category</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $course->category->name ?? 'Uncategorized' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Duration</p>
                                <p class="text-lg font-semibold text-gray-800">
                                    @if($course->start_date && $course->end_date)
                                        {{ \Carbon\Carbon::parse($course->start_date)->format('M d, Y') }} – 
                                        {{ \Carbon\Carbon::parse($course->end_date)->format('M d, Y') }}
                                    @else
                                        Self-paced
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Lessons</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $totalLessons }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md">
                <div class="border-b border-neutral-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-align-left mr-2 text-primary-500"></i> Course Description
                    </h3>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none">
                        @if($course->description)
                            <p class="text-gray-700 leading-relaxed">{!! nl2br(e($course->description)) !!}</p>
                        @else
                            <p class="text-gray-500 italic">No description provided for this course.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md">
                <div class="border-b border-neutral-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-play-circle mr-2 text-primary-500"></i> Course Lessons
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $totalLessons }} lessons</p>
                </div>
                <div class="p-6">
                    @if ($course->contents->isEmpty())
                        <div class="text-center py-8">
                            <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No lessons available yet</h4>
                            <p class="text-gray-600">Lessons will be added soon by the instructor.</p>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach ($course->contents as $idx => $content)
                                <div class="flex items-center justify-between p-4 border border-neutral-100 rounded-lg hover:bg-primary-50 transition duration-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-4">
                                            {{ $idx + 1 }}
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">{{ $content->title }}</h4>
                                            @if($content->description)
                                                <p class="text-sm text-gray-600 mt-1 line-clamp-1">{{ $content->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @auth
                                        @if ($isStudent && $isEnrolled)
                                            <a href="{{ route('lessons.show', [$course->id, $content->id]) }}"
                                                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center">
                                                <i class="fas fa-play mr-2"></i> Start
                                            </a>
                                        @else
                                            <span class="text-gray-400 px-4 py-2 rounded-lg border border-gray-300">
                                                <i class="fas fa-lock mr-2"></i> Locked
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 px-4 py-2 rounded-lg border border-gray-300">
                                            <i class="fas fa-lock mr-2"></i> Locked
                                        </span>
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
@include('courses.partials.reviews')

        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md">
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-4 rounded-t-xl">
                    <h3 class="text-lg font-semibold text-white text-center">Get Started</h3>
                </div>
                <div class="p-6">
                    @auth
                        @if ($isStudent)
                            @if ($isEnrolled)
                                <div class="text-center mb-6">
                                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white mx-auto mb-4">
                                        <i class="fas fa-check text-xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">You're Enrolled!</h4>
                                    <p class="text-gray-600 mb-4">Continue your learning journey</p>
                                    <div class="mb-6">
                                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                                            <span>Your Progress</span>
                                            <span>{{ $progress }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="bg-primary-500 h-3 rounded-full transition-all duration-500" 
                                                    style="width: {{ $progress }}%"></div>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>{{ $completedCount }}</strong> of <strong>{{ $totalLessons }}</strong> lessons completed
                                        </p>
                                    </div>
                                    <div class="space-y-3">
                                        @php
                                            $firstLesson = $course->contents->first();
                                            $nextLesson = $course->contents->firstWhere('order', '>', $completedCount) ?? $firstLesson;
                                        @endphp

                                        @if ($nextLesson)
                                            <a href="{{ route('lessons.show', [$course->id, $nextLesson->id]) }}"
                                                class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 flex items-center justify-center">
                                                <i class="fas fa-play mr-2"></i> 
                                                {{ $completedCount > 0 ? 'Continue Learning' : 'Start Learning' }}
                                            </a>
                                        @endif

                                        <form action="{{ route('courses.unenroll', $course->id) }}" method="POST" class="w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to unenroll from this course? Your progress will be lost.')"
                                                    class="w-full border border-red-500 text-red-500 hover:bg-red-50 py-3 px-4 rounded-lg font-medium transition duration-300 flex items-center justify-center">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Unenroll
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center text-white mx-auto mb-4">
                                        <i class="fas fa-graduation-cap text-xl"></i>
                                    </div>
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Enroll in this Course</h4>
                                    <p class="text-gray-600 mb-6">Start your learning journey today</p>
                                    
                                    <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                                class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 flex items-center justify-center">
                                            <i class="fas fa-plus mr-2"></i> Enroll Now
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @else
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white mx-auto mb-4">
                                    <i class="fas fa-user-shield text-xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Viewing as {{ ucfirst(auth()->user()->role) }}</h4>
                                <p class="text-gray-600 mb-4">You have instructor/admin access to this course</p>
                                
                                @if (in_array(auth()->user()->role, ['admin', 'teacher']) && 
                                        (auth()->user()->role === 'admin' || $course->teacher_id === auth()->id()))
                                    <a href="{{ route('courses.edit', $course) }}"
                                        class="w-full bg-secondary-500 hover:bg-secondary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 flex items-center justify-center mb-3">
                                        <i class="fas fa-edit mr-2"></i> Edit Course
                                    </a>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-500 rounded-full flex items-center justify-center text-white mx-auto mb-4">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-2">Join to Enroll</h4>
                            <p class="text-gray-600 mb-6">Sign in to start learning</p>
                            
                            <div class="space-y-3">
                                <a href="{{ route('login') }}"
                                    class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Login to Enroll
                                </a>
                                <a href="{{ route('register') }}"
                                    class="w-full border border-primary-500 text-primary-500 hover:bg-primary-50 py-3 px-4 rounded-lg font-medium transition duration-300 flex items-center justify-center">
                                    <i class="fas fa-user-plus mr-2"></i> Create Account
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-chart-bar mr-2 text-primary-500"></i> Course Stats
                </h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Students</span>
                        <span class="font-semibold text-gray-800">{{ $course->students_count }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Lessons</span>
                        <span class="font-semibold text-gray-800">{{ $totalLessons }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Course Duration</span>
                        <span class="font-semibold text-gray-800">
                            @if($course->start_date && $course->end_date)
                                {{ \Carbon\Carbon::parse($course->start_date)->diffInDays($course->end_date) }} days
                            @else
                                Self-paced
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Last Updated</span>
                        <span class="font-semibold text-gray-800">{{ $course->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            @if($course->teacher && $course->teacher->email)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-envelope mr-2 text-primary-500"></i> Contact Instructor
                </h4>
                <p class="text-gray-600 mb-4">Have questions about this course?</p>
                <a href="mailto:{{ $course->teacher->email }}" 
                    class="w-full bg-secondary-500 hover:bg-secondary-600 text-white py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i> Send Message
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .sticky {
        position: sticky;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lessonLinks = document.querySelectorAll('a[href*="lessons.show"]');
        lessonLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Loading...';
                this.disabled = true;
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            });
        });

        const progressBar = document.querySelector('.bg-primary-500');
        if (progressBar) {
            progressBar.style.width = '0%';
            setTimeout(() => {
                progressBar.style.width = progressBar.style.width;
            }, 100);
        }
    });
</script>
@endsection