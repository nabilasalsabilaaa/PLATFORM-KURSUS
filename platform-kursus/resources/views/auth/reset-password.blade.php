@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-soft-card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                Reset Password
            </h1>
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            class="w-full p-3 border border-neutral-200 rounded-lg
                                    focus:ring-2 focus:ring-primary-500 focus:outline-none
                                    text-sm text-gray-800 placeholder-gray-400">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="w-full p-3 border border-neutral-200 rounded-lg
                                    focus:ring-2 focus:ring-primary-500 focus:outline-none
                                    text-sm text-gray-800 placeholder-gray-400">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirm Password
                    </label>
                    <input id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="w-full p-3 border border-neutral-200 rounded-lg
                                    focus:ring-2 focus:ring-primary-500 focus:outline-none
                                    text-sm text-gray-800 placeholder-gray-400">
                </div>
                <button type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-2.5 rounded-xl
                                text-sm flex items-center justify-center gap-2 transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fas fa-sync text-xs"></i>
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
