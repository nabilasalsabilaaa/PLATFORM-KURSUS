@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Contents for: ') }} <span class="text-indigo-600">{{ $course->title }}</span>
    </h2>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            @endif
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 mb-8 text-white shadow-lg">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl font-bold mb-2">Course Contents</h1>
                        <p class="text-indigo-100 opacity-90">Manage and organize your course materials</p>
                    </div>
                    <a href="{{ route('contents.create', $course) }}"
                        class="inline-flex items-center px-5 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-50 transition-all duration-300 shadow-md hover:shadow-lg">
                        + New Content
                    </a>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($contents as $content)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold text-sm">
                                        {{ $content->order }}
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('contents.edit', [$course, $content]) }}"
                                        class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-lg text-sm hover:bg-yellow-200 transition-colors"
                                        title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('contents.destroy', [$course, $content]) }}" method="POST"
                                            onsubmit="return confirm('Delete this content?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-sm hover:bg-red-200 transition-colors"
                                                title="Delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <h3 class="font-bold text-gray-900 text-lg mb-2 line-clamp-2">{{ $content->title }}</h3>
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($content->isVideo()) bg-blue-100 text-blue-800
                                @elseif($content->isText()) bg-green-100 text-green-800
                                @elseif($content->isQuiz()) bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                @if($content->isVideo())
                                Video
                                @elseif($content->isText())
                                Text
                                @elseif($content->isQuiz())
                                Quiz
                                @endif
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($content->body), 120) ?: 'No content preview available' }}
                            </p>
                            <div class="text-xs text-gray-500">
                                Duration: {{ $content->duration ?: 'Not set' }}
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <a href="{{ route('contents.edit', [$course, $content]) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                Manage Content
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 mb-4 text-gray-300 text-6xl">
                                📝
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No content yet</h3>
                            <p class="text-gray-500 mb-6 max-w-sm mx-auto">Get started by creating your first course content.</p>
                            <a href="{{ route('contents.create', $course) }}"
                                class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                + Create First Content
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('courses.index') }}" 
                    class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    ← Back to Courses
                </a>
                
                @if($contents->count() > 0)
                <div class="text-sm text-gray-500">
                    Showing {{ $contents->count() }} content{{ $contents->count() > 1 ? 's' : '' }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection