@extends('layouts.app')

@section('content')
    <h1>Reset Password</h1>
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                required
                autofocus>
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
        <button type="submit">Reset Password</button>
    </form>
@endsection