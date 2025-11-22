@extends('layouts.app')

@section('content')
    <h1>Register</h1>
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label for="name">Name</label><br>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="password">Password</label><br>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="password_confirmation">Confirm Password</label><br>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="role">Role</label><br>
            <select id="role" name="role" required>
                <option value="">-- Select Role --</option>
                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
            </select>
        </div>
        <div style="margin-top: 10px;">
            <a href="{{ route('login') }}">Already registered?</a>
        </div>
        <div style="margin-top: 10px;">
            <button type="submit">Register</button>
        </div>
    </form>
@endsection