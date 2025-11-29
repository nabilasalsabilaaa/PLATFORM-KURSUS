@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-soft-card p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2 text-center">
                Confirm Password
            </h1>
            <p class="text-gray-600 text-sm text-center mb-6">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full p-3 border border-neutral-200 rounded-lg
                                    focus:ring-2 focus:ring-primary-500 focus:outline-none
                                    text-sm text-gray-800 placeholder-gray-400">
                </div>

                <button type="submit"
                        class="w-full bg-primary-500 hover:bg-primary-600 text-white font-medium py-2.5 rounded-xl
                                text-sm flex items-center justify-center gap-2 transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fas fa-lock text-xs"></i>
                    Confirm
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
