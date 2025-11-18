{{-- resources/views/courses/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Course') }}
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

                <form action="{{ route('courses.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text"
                                      class="mt-1 block w-full"
                                      :value="old('title')" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                  rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-text-input id="start_date" name="start_date" type="date"
                                          class="mt-1 block w-full"
                                          :value="old('start_date')" />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-text-input id="end_date" name="end_date" type="date"
                                          class="mt-1 block w-full"
                                          :value="old('end_date')" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    @if ($user->role === 'admin')
                        <div class="mb-4">
                            <x-input-label for="teacher_id" :value="__('Teacher')" />
                            <select id="teacher_id" name="teacher_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Teacher --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }} ({{ $teacher->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mb-4">
                            Teacher: <span class="font-semibold">{{ $user->name }}</span> (otomatis)
                        </p>
                    @endif

                    <div class="flex justify-end">
                        <x-primary-button>
                            {{ __('Save') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
