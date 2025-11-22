@extends('layouts.app')

@section('content')
    <h1>Edit User</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 10px;">
            <label for="name">Name</label><br>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="role">Role</label><br>
            <select id="role" name="role" required>
                <option value="admin"   {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>

        <div style="margin-bottom: 10px;">
            <label>
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                Active
            </label>
        </div>

        <div style="margin-bottom: 10px;">
            <p><strong>Password (optional)</strong></p>
            <p>Biarkan kosong kalau tidak ingin mengganti password.</p>
            <label for="password">New Password</label><br>
            <input id="password" type="password" name="password">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="password_confirmation">Confirm New Password</label><br>
            <input id="password_confirmation" type="password" name="password_confirmation">
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
