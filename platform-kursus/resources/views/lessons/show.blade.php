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
                        @if($c->isVideo())
                        <span class="text-xs text-blue-500 ml-1">📹</span>
                        @elseif($c->isQuiz())
                        <span class="text-xs text-green-500 ml-1">❓</span>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="md:col-span-3 bg-white shadow rounded p-6">
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
            
            <h2 class="text-2xl font-semibold mb-4"> {{ $content->title }} </h2>

            @if($content->description)
            <p class="text-gray-600 mb-4">{{ $content->description }}</p>
            @endif

            @if($content->isVideo() && $content->getVideoUrl())
            <div class="mb-6">
                <div class="bg-black rounded-lg overflow-hidden">
                    @if(str_contains($content->getVideoUrl(), 'youtube.com') || str_contains($content->getVideoUrl(), 'youtu.be'))
                    <iframe src="{{ $content->getVideoUrl() }}" 
                            class="w-full h-64 md:h-96" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>

                    @else
                    <video controls class="w-full h-64 md:h-96">
                        <source src="{{ $content->getVideoUrl() }}" type="video/mp4"> Your browser does not support the video tag.
                    </video>
                    @endif
                </div>

                @if($content->duration)
                <p class="text-sm text-gray-500 mt-2">Duration: {{ $content->duration }}</p>
                @endif
                <div class="mt-4 flex justify-end">
                    <button type="button"
                            onclick="openQuizModal()"
                            class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg text-sm font-medium shadow-md transition">
                        Buka Quiz
                    </button>
                </div>
            </div>
            @endif

            @if($content->isText())
            <div class="prose mb-6"> {!! nl2br(e($content->body)) !!} </div>
            @endif

            @if(!$content->isQuiz())
                @if (! $isCompleted)
                <form action="{{ route('lessons.done', [$course, $content]) }}" method="POST" class="mb-6">
                    @csrf
                    <button class="px-4 py-2 bg-green-600 text-white rounded">Mark as Done</button>
                </form>

                @else
                <p class="text-green-700 font-bold mb-6">Lesson completed ✔️</p>
                @endif
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
                        <span class="text-gray-400">Complete this lesson to unlock →</span>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div id="quiz-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
            <div class="bg-white rounded-2xl shadow-lg max-w-xl w-full mx-4 p-6 relative">
                <button type="button"
                    onclick="closeQuizModal()"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
                <h3 class="text-lg font-semibold mb-2"> Quiz: {{ $content->title }}</h3>
                <p class="text-sm text-gray-500 mb-4">Ini hanya tampilan quiz (UI), jawaban tidak akan disimpan.</p>
                
                <div class="space-y-4 max-h-80 overflow-y-auto">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium mb-2">1. Kenapa bumi bulat?</h4>
                        <ul class="space-y-1 text-sm">
                            <li>
                                <label class="flex items-center gap-2">
                                    <input type="radio" disabled class="text-primary-500">
                                    <span>karena kalau bulat itu bakso</span>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2">
                                    <input type="radio" disabled>
                                    <span>gak tau</span>
                                </label>
                            </li>
                            <li>
                                <label class="flex items-center gap-2">
                                    <input type="radio" disabled>
                                    <span>skip. sok a6</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-5 flex justify-end gap-2">
                    <button type="button"
                        onclick="closeQuizModal()"
                        class="px-4 py-2 text-sm rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                        Tutup
                    </button>
                </div>  
            </div>
        </div>
        
        <script>
            function openQuizModal() {
                const modal = document.getElementById('quiz-modal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeQuizModal() {
                const modal = document.getElementById('quiz-modal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        </script>
    </div>
@endsection