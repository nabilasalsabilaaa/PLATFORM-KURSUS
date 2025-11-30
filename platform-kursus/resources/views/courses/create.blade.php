@extends('layouts.app')

@section('title', 'Create Course - Bwakekoqq Platform')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Create Course') }}</h2>
            <p class="text-gray-600 mt-1">Create a new course to share your knowledge</p>
        </div>
        <a href="{{ route('courses.index') }}" 
            class="inline-flex items-center text-primary-500 hover:text-primary-600 transition duration-300">
            <i class="fas fa-arrow-left mr-2"></i> Back to Courses
        </a>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 rounded-full bg-white bg-opacity-20 mr-3">
                        <i class="fas fa-book-open text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Course Information</h3>
                        <p class="text-white text-opacity-90 text-sm">Fill in the details to create your new course</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            </div>
                            <div>
                                <p class="font-medium">Please fix the following errors:</p>
                                <ul class="list-disc list-inside mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Title <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-heading text-gray-400"></i>
                            </div>
                            <input id="title" 
                                    name="title" 
                                    type="text"
                                    value="{{ old('title') }}" 
                                    required
                                    class="block w-full pl-10 pr-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300"
                                    placeholder="Enter course title">
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Description
                        </label>
                        <div class="relative">
                            <textarea id="description" 
                                        name="description"
                                        rows="5"
                                        class="block w-full px-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300"
                                        placeholder="Describe what students will learn in this course">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input id="start_date" 
                                        name="start_date" 
                                        type="date"
                                        value="{{ old('start_date') }}"
                                        class="block w-full pl-10 pr-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300">
                            </div>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                End Date
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-check text-gray-400"></i>
                                </div>
                                <input id="end_date" 
                                        name="end_date" 
                                        type="date"
                                        value="{{ old('end_date') }}"
                                        class="block w-full pl-10 pr-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Course Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-toggle-on text-gray-400"></i>
                            </div>
                            <select id="status" 
                                    name="status"
                                    class="block w-full pl-10 pr-10 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 appearance-none bg-white">
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <select id="category_id" 
                                    name="category_id"
                                    required
                                    class="block w-full pl-10 pr-10 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 appearance-none bg-white">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    @if ($user->role === 'admin')
                        <div>
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Teacher <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chalkboard-teacher text-gray-400"></i>
                                </div>
                                <select id="teacher_id" 
                                        name="teacher_id"
                                        required
                                        class="block w-full pl-10 pr-10 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 appearance-none bg-white">
                                    <option value="">-- Select Teacher --</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }} ({{ $teacher->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-primary-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-primary-800">Course Instructor</h4>
                                    <p class="text-sm text-primary-700">This course will be assigned to <strong>{{ $user->name }}</strong> (you)</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="pt-6 border-t border-neutral-100">
                        <button type="submit"
                                class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i> Create Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-6 bg-secondary-50 rounded-xl p-6">
            <h3 class="text-lg font-medium text-secondary-800 mb-4 flex items-center">
                <i class="fas fa-lightbulb mr-2"></i> Tips for Creating Great Courses
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-secondary-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-secondary-800">Clear Title</h4>
                        <p class="text-sm text-secondary-700">Choose a descriptive and engaging title</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-secondary-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-secondary-800">Detailed Description</h4>
                        <p class="text-sm text-secondary-700">Explain what students will learn</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-secondary-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-secondary-800">Proper Category</h4>
                        <p class="text-sm text-secondary-700">Select the most relevant category</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-secondary-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-secondary-800">Realistic Timeline</h4>
                        <p class="text-sm text-secondary-700">Set appropriate start and end dates</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('description');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
            
            textarea.dispatchEvent(new Event('input'));
        }

        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        if (startDateInput && endDateInput) {
            startDateInput.addEventListener('change', function() {
                if (this.value && endDateInput.value && this.value > endDateInput.value) {
                    endDateInput.value = '';
                    console.log('End date cannot be before start date');
                }
            });

            endDateInput.addEventListener('change', function() {
                if (this.value && startDateInput.value && this.value < startDateInput.value) {
                    alert('End date cannot be before start date');
                    this.value = '';
                }
            });
        }
    });
</script>
@endsection