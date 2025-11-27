@extends('layouts.app')

@section('title', 'Edit Category - Bwakekoqq Platform')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="mb-8">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-primary-500 hover:text-primary-600 transition duration-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to Categories
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Category</h1>
                <p class="text-gray-600 mt-2">Update category information for {{ $category->name }}</p>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-12 h-12 bg-secondary-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    {{ substr($category->name, 0, 1) }}
                </div>
                <div class="hidden sm:block">
                    <p class="font-medium text-gray-900">{{ $category->name }}</p>
                    <p class="text-sm text-gray-500">{{ $category->courses()->count() }} courses</p>
                </div>
            </div>
        </div>
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

        <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
            @csrf
            @method('PUT')

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
                            value="{{ old('name', $category->name) }}" 
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
                                placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-4 rounded-lg font-medium transition duration-300 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Update Category
                </button>
            </div>
        </form>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow-md p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-green-50 text-green-500 mr-3">
                    <i class="fas fa-book-open"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Courses</p>
                    <p class="text-lg font-bold text-gray-800">{{ $category->courses()->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4">
            <div class="flex items-center">
                <div class="p-2 rounded-full bg-blue-50 text-blue-500 mr-3">
                    <i class="fas fa-calendar"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Last Updated</p>
                    <p class="text-lg font-bold text-gray-800">{{ $category->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($category->courses()->count() === 0)
    <div class="mt-6 border border-red-200 rounded-xl p-5 bg-red-50">
        <h3 class="text-base font-semibold text-red-800 mb-2">Danger Zone</h3>
        <p class="text-sm text-red-600 mb-4">
            Once you delete a category, there is no going back. Please be certain.
        </p>
        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm py-2 px-4 rounded-lg transition duration-300">
                <i class="fas fa-trash mr-2"></i> Delete Category
            </button>
        </form>
    </div>
    @else
    <div class="mt-6 border border-red-200 rounded-xl p-5 bg-red-50">
        <h3 class="text-base font-semibold text-red-800 mb-2">Danger Zone</h3>
        <p class="text-sm text-red-700 mb-2">
            This category contains <strong>{{ $category->courses()->count() }}</strong> course(s). 
            Deleting this category will also permanently remove all associated courses.
        </p>
        <p class="text-xs text-red-600 mb-4">
            This action cannot be undone. Proceed only if you’re sure.
        </p>
        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Are you sure you want to delete this category? All related courses will be permanently removed.')"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm py-2 px-4 rounded-lg transition duration-300">
                <i class="fas fa-trash mr-2"></i> Delete Category
            </button>
        </form>
    </div>
    @endif
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