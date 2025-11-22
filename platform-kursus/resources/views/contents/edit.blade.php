@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Content: ') }} {{ $content->title }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
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

                <form action="{{ route('contents.update', [$course, $content]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            {{ __('Title') }}
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title', $content->title) }}"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">
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
                            value="{{ old('order', $content->order) }}"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label for="body" class="block text-sm font-medium text-gray-700">
                            {{ __('Content Body') }}
                        </label>
                        <textarea
                            id="body"
                            name="body"
                            rows="6"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ old('body', $content->body) }}</textarea>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('contents.index', $course) }}"
                        class="text-sm text-gray-600 hover:underline">
                            ← Back
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                                    rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                    hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                    focus:ring-offset-2">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection