@extends('layouts.app')

@section('title', 'User Management - Bwakekoqq Platform')

@section('content')

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
</style>

<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <p class="text-gray-600 mt-2">Kelola semua pengguna platform Chills Kursus</p>
        </div>
        <a href="{{ route('users.create') }}" 
            class="mt-4 md:mt-0 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-lg transition duration-300 flex items-center">
            <i class="fas fa-user-plus mr-2"></i>
            Create User
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

    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <div class="flex">
                <div class="py-1">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                </div>
                <div>
                    <p class="font-medium">Error!</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-primary-50 text-primary-500 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $users->total() }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-secondary-50 text-secondary-500 mr-4">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Admins</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $users->where('role', 'admin')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-50 text-orange-500 mr-4">
                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Teachers</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $users->where('role', 'teacher')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-50 text-blue-500 mr-4">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Students</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ $users->where('role', 'student')->count() }}
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
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-neutral-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-primary-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                        ($user->role === 'teacher' ? 'bg-secondary-100 text-secondary-800' : 
                                        'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('users.edit', $user) }}" 
                                        class="text-primary-500 hover:text-primary-700 transition duration-300">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                                    class="text-red-500 hover:text-red-700 transition duration-300">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                    <p class="text-gray-500 mb-4">Get started by creating a new user.</p>
                                    <a href="{{ route('users.create') }}" 
                                        class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg transition duration-300">
                                        Create Your First User
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="bg-white px-6 py-4 border-t border-neutral-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection