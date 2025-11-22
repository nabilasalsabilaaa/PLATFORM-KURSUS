@extends('layouts.app')

@section('content')
    <h1>Categories</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('categories.create') }}">+ Add Category</a>
    </p>

    <table border="1" cellpadding="6" cellspacing="0" style="margin-top:10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Courses Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->courses()->count() }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">Edit</a>

                        <form action="{{ route('categories.destroy', $category) }}"
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:10px;">
        {{ $categories->links() }}
    </div>
@endsection
