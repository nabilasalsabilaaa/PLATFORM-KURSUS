@extends('layouts.app')

@section('header')
    <h2 class="font-bold text-xl">
        {{ $course->title }} — {{ $content->title }}
    </h2>
@endsection

@section('content')
    <div class="py-8 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="md:col-span-1 bg-white shadow rounded p-4">
            <h3 class="font-semibold mb-3">Course Lessons</h3>

            <ul class="space-y-2">
                @foreach ($contents as $c)
                    <li>
                        <a href="{{ route('lessons.show', [$course, $c]) }}"
                            class="block p-2 rounded 
                                {{ $c->id == $content->id ? 'bg-indigo-100' : 'hover:bg-gray-100' }}">
                            {{ $c->order }}. {{ $c->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="md:col-span-3 bg-white shadow rounded p-6">

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <p class="mb-3 text-green-600 font-semibold">
                    {{ session('success') }}
                </p>
            @endif

            @if (session('error'))
                <p class="mb-3 text-red-600 font-semibold">
                    {{ session('error') }}
                </p>
            @endif

            <h2 class="text-2xl font-semibold mb-4">
                {{ $content->title }}
            </h2>

            <div class="prose mb-6">
                {!! nl2br(e($content->body)) !!}
            </div>

            @if (! $isCompleted)
                <form action="{{ route('lessons.done', [$course, $content]) }}" method="POST" class="mb-6">
                    @csrf
                    <button class="px-4 py-2 bg-green-600 text-white rounded">
                        Mark as Done
                    </button>
                </form>
            @else
                <p class="text-green-700 font-bold mb-6">
                    Lesson completed ✔️
                </p>
            @endif

            <hr class="my-6">

            <div class="flex justify-between">

                <div>
                    @if ($previousLesson)
                        <a href="{{ route('lessons.show', [$course, $previousLesson]) }}"
                            class="text-blue-600 hover:underline">
                            ← {{ $previousLesson->title }}
                        </a>
                    @endif
                </div>

                <div>
                    @if ($nextLesson)
                        @if ($isCompleted)
                            <a href="{{ route('lessons.show', [$course, $nextLesson]) }}"
                                class="text-blue-600 hover:underline">
                                {{ $nextLesson->title }} →
                            </a>
                        @else
                            <span class="text-gray-400">
                                Complete this lesson to unlock →
                            </span>
                        @endif
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection
