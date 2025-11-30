@extends('layouts.app')

@section('title', 'Categories - Bwakekoqq Platform')

@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Categories</h1>
            <p class="text-gray-600 mt-2">Kelola kategori agar kursus lebih terorganisir</p>
        </div>
        <a href="{{ route('categories.create') }}" 
            class="mt-4 md:mt-0 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg transition duration-300 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Add Category
        </a>
    </div>
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
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary-50 text-primary-500 mr-4">
                    <i class="fas fa-folder text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Categories</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $categories->total() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary-50 text-secondary-500 mr-4">
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Courses</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $categories->sum(fn($category) => $category->courses()->count()) }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-50 text-orange-500 mr-4">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Avg Courses/Category</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $categories->count() > 0 ? round($categories->sum(fn($category) => $category->courses()->count()) / $categories->count(), 1) : 0 }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-100">
                <thead class="bg-neutral-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Courses Count
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-primary-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $category->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-secondary-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($category->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs">
                                <div class="line-clamp-2">
                                    {{ $category->description ?: 'No description' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $category->courses()->count() > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $category->courses()->count() }} courses
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <a href="{{ route('categories.edit', $category) }}" 
                                        class="text-primary-500 hover:text-primary-700 transition duration-300 flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}" 
                                            method="POST" 
                                            class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')"
                                                class="text-red-500 hover:text-red-700 transition duration-300 flex items-center">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-folder-open text-4xl text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                                    <p class="text-gray-500 mb-4">Get started by creating your first category.</p>
                                    <a href="{{ route('categories.create') }}" 
                                        class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition duration-300">
                                        Create First Category
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->hasPages())
            <div class="bg-white px-6 py-4 border-t border-neutral-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <div class="mt-8 bg-primary-50 rounded-xl p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('categories.create') }}" 
                class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300">
                <div class="p-3 rounded-full bg-primary-100 text-primary-500 mr-4">
                    <i class="fas fa-plus"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-800">Add New Category</h4>
                    <p class="text-sm text-gray-600">Create a new course category</p>
                </div>
            </a>
            
            <a href="{{ route('courses.catalog') }}" 
                class="flex items-center p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300">
                <div class="p-3 rounded-full bg-secondary-100 text-secondary-500 mr-4">
                    <i class="fas fa-eye"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-800">View Course Catalog</h4>
                    <p class="text-sm text-gray-600">See all courses by category</p>
                </div>
            </a>
        </div>
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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('form[action*="categories"]');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const courseCount = this.closest('tr').querySelector('[class*="bg-green-100"]');
                const count = courseCount ? parseInt(courseCount.textContent) : 0;
                
                let message = 'Are you sure you want to delete this category?';
                if (count > 0) {
                    message += ` This category has ${count} course(s) that will be affected.`;
                }
                message += ' This action cannot be undone.';
                
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection