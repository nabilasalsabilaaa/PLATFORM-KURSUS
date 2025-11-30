@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-soft-card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2 text-center">Forgot Password</h1>
            <p class="text-gray-600 text-sm text-center mb-6">
                Forgot your password? No problem. Just let us know your email address and 
                we will email you a password reset link that will allow you to choose a new one.
            </p>
            @if (session('status'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <input id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required autofocus
                                class="w-full p-3 border border-neutral-200 rounded-lg pl-3
                                        focus:ring-2 focus:ring-primary-500 focus:outline-none
                                        text-sm text-gray-800 placeholder-gray-400" />
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-2.5 rounded-xl
                                text-sm flex items-center justify-center gap-2 transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fas fa-paper-plane text-xs"></i>
                    Send Password Reset Link
                </button>
            </form>
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                    class="text-primary-500 text-sm hover:text-primary-600 transition-colors">
                    Back to Login
                </a>
            </div>

        </div>
    </div>
</div>
@endsection