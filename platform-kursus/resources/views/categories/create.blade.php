@extends('layouts.app')

@section('title', 'Create Category - Bwakekoqq Platform')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="mb-8">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-primary-500 hover:text-primary-600 transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to Categories
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Create New Category</h1>
        <p class="text-gray-600 mt-2">Add a new course category to organize your courses</p>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
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

        <form method="POST" action="{{ route('categories.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required
                            class="block w-full pl-10 pr-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300"
                            placeholder="Enter category name">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description (Optional)
                </label>
                <div class="relative">
                    <textarea id="description" 
                            name="description" 
                            rows="4"
                            class="block w-full px-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300"
                            placeholder="Enter category description">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i> Create Category
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 bg-primary-50 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-primary-500"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-primary-800">Information</h3>
                <div class="mt-2 text-sm text-primary-700">
                    <ul class="list-disc ml-4">
                        <li>Category names should be clear and descriptive</li>
                        <li>Use descriptions to provide more context about the category</li>
                        <li>Categories help organize courses for better user experience</li>
                    </ul>
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
    });
</script>
@endsection