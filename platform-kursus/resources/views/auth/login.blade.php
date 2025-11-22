@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    @if (session('status'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="password">Password</label><br>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password">
        </div>
        <div style="margin-bottom: 10px;">
            <label for="remember_me">
                <input type="checkbox" id="remember_me" name="remember">
                Remember me
            </label>
        </div>
        <div style="margin-top: 10px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>
        <div style="margin-top: 10px;">
            <button type="submit">Log in</button>
        </div>
    </form>
@endsection