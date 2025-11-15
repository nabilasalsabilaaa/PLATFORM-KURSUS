<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
        $roleLabel = ucfirst($user->role);
    @endphp
        
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <h1 class="text-2xl font-bold mb-2">
                        Welcome, {{ $roleLabel }}!
                    </h1>

                    <p>Nama: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Role: <span class="font-semibold">{{ $user->role }}</span></p>

                    <div class="mt-4">
                        @if ($user->role === 'admin')
                            <p>Ini area Admin (nanti di sini ada menu manajemen user & course).</p>
                        @elseif ($user->role === 'teacher')
                            <p>Ini area Teacher (nanti ada daftar course yang kamu ajar).</p>
                        @elseif ($user->role === 'student')
                            <p>Ini area Student (nanti ada course yang kamu ikuti & progress).</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
