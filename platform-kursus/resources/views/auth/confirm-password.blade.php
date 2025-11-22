@extends('layouts.app')

@section('content')
    <h1>Confirm Password</h1>
    <p>This is a secure area of the application. Please confirm your password before continuing.</p>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div>
            <label for="password">Password</label><br>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>
        <div>
            <button type="submit">
                Confirm
            </button>
        </div>
    </form>
@endsection