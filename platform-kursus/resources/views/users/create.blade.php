@extends('layouts.app')

@section('content')
    <h1>Create User</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <div style="margin-bottom: 10px;">
            <label for="name">Name</label><br>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="password">Password</label><br>
            <input id="password" type="password" name="password" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="password_confirmation">Confirm Password</label><br>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="role">Role</label><br>
            <select id="role" name="role" required>
                <option value="">-- Select Role --</option>
                <option value="admin"   {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="is_active">Status</label>
            <select name="is_active" id="is_active">
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit">Save</button>
    </form>
@endsection
