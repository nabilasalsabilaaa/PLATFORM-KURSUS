@extends('layouts.app')

@section('title', 'Dashboard - Chills Kursus')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Selamat Datang, <span class="text-primary-500">{{ Auth::user()->name }}</span>!
                </h1>
                <p class="text-gray-600">
                    Anda login sebagai <span class="font-semibold text-primary-500 capitalize">{{ Auth::user()->role }}</span>.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                    <i class="fas fa-user mr-2"></i>
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6 h-full">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Akses Cepat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('profile.edit') }}" class="flex items-center p-4 border border-neutral-100 rounded-lg hover:bg-purple-50 transition duration-300">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Pengaturan</h3>
                            <p class="text-sm text-gray-600">Atur akun Anda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-xl shadow-sm p-6 h-full">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Akun</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-primary-500 rounded-full flex items-center justify-center text-white text-xl font-bold mr-4">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                            <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            <span class="inline-block mt-1 px-2 py-1 bg-primary-100 text-primary-800 text-xs rounded-full capitalize">
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection