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
                            class="block p-2 rounded {{ $c->id == $content->id ? 'bg-indigo-100' : 'hover:bg-gray-100' }}">
                            {{ $c->order }}. {{ $c->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="md:col-span-3 bg-white shadow rounded p-6">
            <h2 class="text-2xl font-semibold mb-4">
                {{ $content->title }}
            </h2>

            <div class="prose">
                {!! nl2br(e($content->body)) !!}
            </div>

            <form action="{{ route('lessons.done', [$course, $content]) }}" method="POST" class="mt-6">
                @csrf
                <button class="px-4 py-2 bg-green-600 text-white rounded">
                    Mark as Done
                </button>
            </form>
        </div>
    </div>
@endsection