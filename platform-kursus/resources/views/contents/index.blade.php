{{-- resources/views/contents/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contents for: ') }} {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Content List</h3>

                <a href="{{ route('contents.create', $course) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md">
                    + New Content
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-left text-sm text-gray-700">
                    <thead class="border-b bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 w-16">Order</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Preview</th>
                            <th class="px-4 py-2 w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contents as $content)
                            <tr class="border-b">
                                <td class="px-4 py-2 align-top">
                                    {{ $content->order }}
                                </td>
                                <td class="px-4 py-2 align-top font-semibold">
                                    {{ $content->title }}
                                </td>
                                <td class="px-4 py-2 align-top text-gray-600">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($content->body), 80) ?: '-' }}
                                </td>
                                <td class="px-4 py-2 align-top">
                                    <div class="flex gap-2">
                                        <a href="{{ route('contents.edit', [$course, $content]) }}"
                                           class="px-3 py-1 text-xs rounded bg-yellow-100 text-yellow-800">
                                            Edit
                                        </a>
                                        <form action="{{ route('contents.destroy', [$course, $content]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this content?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 text-xs rounded bg-red-100 text-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                    No content found for this course.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="{{ route('courses.index') }}" class="text-sm text-gray-600 hover:underline">
                    ← Back to Courses
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
