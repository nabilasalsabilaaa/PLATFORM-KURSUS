@extends('layouts.app')

@section('content')
    <h1>Edit Category</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 10px;">
            <label for="name">Name</label><br>
            <input id="name" type="text" name="name"
                value="{{ old('name', $category->name) }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="description">Description (optional)</label><br>
            <textarea id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
