@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-soft-card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                Verify Email
            </h1>
            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                Thanks for signing up! Before getting started, please verify your email address
                by clicking on the link we just emailed to you. If you didn't receive the email,
                we will gladly send you another.
            </p>
            @if (session('status') === 'verification-link-sent')
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 text-green-700 px-4 py-3 text-sm">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif
            <div class="mt-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl
                                bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium
                                shadow-soft-card transition-all duration-300 hover:-translate-y-0.5">
                        Resend Verification Email
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl
                                border border-neutral-200 text-sm font-medium text-gray-700
                                bg-white hover:bg-neutral-50 transition-all duration-300">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection