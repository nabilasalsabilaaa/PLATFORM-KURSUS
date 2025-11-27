@extends('layouts.app') 

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Content to: ') }} {{ $course->title }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contents.store', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label for="content_type" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Content Type') }}
                        </label>
                        <select name="content_type" id="content_type" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="text" {{ old('content_type') == 'text' ? 'selected' : '' }}>Text Lesson</option>
                            <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video Lesson</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            {{ __('Title') }}
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            {{ __('Description') }}
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="order" class="block text-sm font-medium text-gray-700">
                            {{ __('Order (Lesson Number)') }}
                        </label>
                        <input
                            id="order"
                            name="order"
                            type="number"
                            min="1"
                            value="{{ old('order') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">

                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika ingin otomatis diisi urutan terakhir.
                        </p>
                    </div>

                    <div id="text-fields" class="mb-4">
                        <label for="body" class="block text-sm font-medium text-gray-700">
                            {{ __('Content Body') }}
                        </label>
                        <textarea
                            id="body"
                            name="body"
                            rows="6"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('body') }}</textarea>
                    </div>

                    <div id="video-fields" class="mb-4 hidden">
                        <div class="mb-4">
                            <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Upload Video File
                            </label>
                            <input type="file" name="video_file" id="video_file" 
                                class="block w-full text-sm text-gray-500">
                            <p class="text-xs text-gray-500 mt-1">Format: MP4, Max: 50MB</p>
                        </div>
                        
                        <div class="text-center text-gray-500 my-2">OR</div>
                        
                        <div class="mb-4">
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Video URL (YouTube, Vimeo, etc.)
                            </label>
                            <input type="url" name="video_url" id="video_url" 
                                value="{{ old('video_url') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="https://youtube.com/embed/...">
                        </div>
                        
                        <div class="mb-4">
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                Duration
                            </label>
                            <input type="text" name="duration" id="duration" 
                                value="{{ old('duration') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="15:30">
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('contents.index', $course) }}"
                            class="text-sm text-gray-600 hover:underline">
                            ← Back
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                    focus:ring-offset-2">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentType = document.getElementById('content_type');
            const textFields = document.getElementById('text-fields');
            const videoFields = document.getElementById('video-fields');
            
            function toggleFields() {
                const type = contentType.value;
                textFields.style.display = type === 'text' ? 'block' : 'none';
                videoFields.style.display = type === 'video' ? 'block' : 'none';
            }
            
            contentType.addEventListener('change', toggleFields);
            toggleFields(); 
        });
    </script>
@endsection