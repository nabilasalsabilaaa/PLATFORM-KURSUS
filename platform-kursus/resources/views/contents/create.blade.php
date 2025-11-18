{{-- resources/views/contents/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Content to: ') }} {{ $course->title }}
        </h2>
    </x-slot>

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

                <form action="{{ route('contents.store', $course) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('title')" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="order" :value="__('Order (Lesson Number)')" />
                        <x-text-input id="order" name="order" type="number" min="1"
                                      class="mt-1 block w-full"
                                      :value="old('order')" />
                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika ingin otomatis diisi urutan terakhir.
                        </p>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="body" :value="__('Content Body')" />
                        <textarea id="body" name="body"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                  rows="6">{{ old('body') }}</textarea>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('contents.index', $course) }}"
                           class="text-sm text-gray-600 hover:underline">
                            ← Back
                        </a>
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
