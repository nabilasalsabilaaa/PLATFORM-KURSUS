@extends('layouts.app')

@section('content')
    <h1>Forgot Password</h1>
    <p>
        Forgot your password? No problem. Just let us know your email address and 
        we will email you a password reset link that will allow you to choose a new one.
    </p>
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
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <button type="submit">
            Send Password Reset Link
        </button>
    </form>
@endsection
