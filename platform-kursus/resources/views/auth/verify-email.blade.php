@extends('layouts.app')

@section('content')
    <h1>Verify Email</h1>
    <p>
        Thanks for signing up! Before getting started, please verify your email address
        by clicking on the link we just emailed to you. If you didn't receive the email,
        we will gladly send you another.
    </p>
    @if (session('status') === 'verification-link-sent')
        <div style="color: green; margin: 10px 0;">
            A new verification link has been sent to the email address you provided during registration.
        </div>
    @endif
    <div style="margin-top: 15px;">
        <form method="POST" action="{{ route('verification.send') }}" style="display: inline-block; margin-right: 10px;">
            @csrf
            <button type="submit">
                Resend Verification Email
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}" style="display: inline-block;">
            @csrf
            <button type="submit">
                Log Out
            </button>
        </form>
    </div>
@endsection