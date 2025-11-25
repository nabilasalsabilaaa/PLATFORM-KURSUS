<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform-Kursus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e8e4fb',
                            100: '#d5d0f7',
                            500: '#716bf0',
                            600: '#5a54d8',
                        },
                        secondary: {
                            50: '#e5f3e9',
                            100: '#d2ebda',
                            500: '#669b63',
                            600: '#558352',
                        },
                        accent: {
                            50: '#ffaa6c',
                            100: '#ff9a52',
                        },
                        neutral: {
                            50: '#e4e6ee',
                            100: '#d8dae5',
                        }
                    },
                    boxShadow: {
                        'soft-card': '0 18px 45px rgba(51, 65, 85, 0.18)',
                    },
                    borderRadius: {
                        '3xl': '1.75rem',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-primary-50 min-h-screen text-gray-800">
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-primary-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3" data-aos="fade-right">
                <div class="bg-primary-500 text-white p-2.5 rounded-xl shadow-soft-card">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-primary-600 tracking-tight">Chills Kursus</h1>
                    <p class="text-xs text-gray-500 -mt-0.5">Find your favorite course</p>
                </div>
            </div>

            <div class="flex items-center gap-4" data-aos="fade-left">
                @auth
                    <div class="hidden md:flex items-center gap-2">
                        <div class="w-9 h-9 bg-primary-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm text-gray-700">
                            Halo, <strong>{{ Auth::user()->name }}</strong>
                        </span>
                    </div>
                    <a href="{{ route('dashboard') }}"
                        class="hidden sm:inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-soft-card transition-all duration-300 hover:-translate-y-0.5">
                        <i class="fas fa-gauge-high text-xs"></i>
                        Dashboard
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="text-primary-500 hover:text-primary-600 font-medium text-sm transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="hidden sm:inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-soft-card transition-all duration-300 hover:-translate-y-0.5">
                        <i class="fas fa-user-plus text-xs"></i>
                        Daftar
                    </a>
                @endguest
            </div>
        </div>
    </header>

    <section class="py-10 md:py-16 bg-gradient-to-b from-primary-100/80 via-primary-50 to-transparent">
        <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-[1.2fr,0.8fr] gap-10 items-center">
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="inline-flex items-center gap-2 bg-white/70 rounded-full px-3 py-1 mb-4 shadow-soft-card">
                    <span class="w-2 h-2 rounded-full bg-accent-50 animate-pulse"></span>
                    <span class="text-xs font-medium text-primary-600 uppercase tracking-wide">
                        Yuk mulai belajar hari ini
                    </span>
                </div>

                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight text-gray-900 mb-3">
                    Temukan Kursus Favoritmu Bersama Chill Kursus!!
                </h2>
                <p class="text-sm md:text-base text-gray-600 mb-6 max-w-xl">
                    Jelajahi kursus terpopuler, temukan dan kembangkan skill kamu di sini.
                </p>

                <div class="relative max-w-2xl">
                    <div class="
                        bg-white/10 border border-white/40
                        rounded-3xl px-4 py-3 md:px-6 md:py-4
                        shadow-soft-card backdrop-blur-md
                    ">
                        <form method="GET" action="{{ route('home') }}" class="flex items-center gap-3">
                            <div class="flex-1 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-gray-600">
                                    <i class="fas fa-search text-sm"></i>
                                </div>
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search anything..."
                                    value="{{ $search }}"
                                    class="w-full bg-transparent border-none focus:outline-none text-sm md:text-base text-white placeholder-gray-600"
                                >
                            </div>

                            <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-2xl bg-accent-50 hover:bg-accent-100 text-white text-sm font-medium transition-all duration-300 hover:-translate-y-0.5">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="relative hidden lg:block" data-aos="fade-left" data-aos-delay="200">
                <div class="absolute -inset-6 bg-primary-500/25 blur-3xl opacity-80 pointer-events-none"></div>
                <div class="relative bg-gradient-to-b from-primary-500 to-primary-600 rounded-[2rem] h-64 shadow-soft-card overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_#ffffff_0,_transparent_55%)] opacity-40"></div>
                    <div class="p-6 flex flex-col justify-between h-full text-white">
                        <div>
                            <p class="text-xs uppercase tracking-[0.18em] text-primary-100/80 mb-2">Learning Journey</p>
                            <h3 class="text-2xl font-bold leading-snug mb-2">
                                Belajar kapan saja, di mana saja.
                            </h3>
                            <p class="text-xs text-primary-50/90 max-w-xs">
                                Akses materi video, latihan, dan proyek praktis yang dirancang untuk membantu kamu naik level.
                            </p>
                        </div>
                        <div class="flex gap-3 text-xs">
                            <div class="flex-1 bg-white/10 rounded-2xl px-3 py-2">
                                <p class="font-semibold">Belajar Fleksibel</p>
                                <p class="text-[11px] text-primary-50/90">Atur kecepatan belajar sesuai jadwalmu.</p>
                            </div>
                            <div class="flex-1 bg-white/10 rounded-2xl px-3 py-2">
                                <p class="font-semibold">Proyek Nyata</p>
                                <p class="text-[11px] text-primary-50/90">Bangun portfolio yang bisa ditunjukkan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-6xl mx-auto px-6 pb-14 space-y-10">
        <section class="space-y-5">
            <div class="flex items-center justify-between" data-aos="fade-up">
                <div>
                    <p class="text-xs uppercase tracking-[0.18em] text-primary-600/70 mb-1">Popular Courses</p>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">5 Kursus Terpopuler</h2>
                </div>
            </div>

            @php
                $popularCourses = $popularCourses ?? collect();
            @endphp

            @if ($popularCourses->isEmpty())
                <div class="bg-white rounded-3xl shadow-soft-card p-10 text-center" data-aos="fade-up">
                    <i class="fas fa-book-open text-4xl text-neutral-100 mb-4"></i>
                    <h3 class="text-lg font-semibold mb-1 text-gray-800">Belum ada kursus yang tersedia</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto">
                        Kami sedang mempersiapkan konten terbaik untuk Anda. Coba kembali beberapa saat lagi.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                    @foreach ($popularCourses as $index => $course)
                        <div class="bg-white rounded-3xl overflow-hidden shadow-soft-card hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group"
                                data-aos="fade-up"
                                data-aos-delay="{{ 100 + ($index % 5) * 80 }}">
                            <div class="relative h-36 bg-gradient-to-tr from-primary-500 to-secondary-500">
                                <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_top,_#ffffff_0,_transparent_55%)]"></div>

                                <div class="absolute top-3 left-3 bg-white/90 text-primary-500 px-2.5 py-1 rounded-full text-[11px] font-semibold">
                                    {{ $course->category->name ?? 'Umum' }}
                                </div>

                                <div class="absolute bottom-3 left-3 flex items-center gap-2 text-[11px] text-white/90">
                                    <i class="fas fa-users text-[10px]"></i>
                                    <span>{{ $course->students_count }} Peserta</span>
                                </div>

                                <div class="absolute bottom-3 right-3 w-8 h-8 rounded-full bg-white/15 border border-white/40 flex items-center justify-center text-[11px]">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>

                            <div class="p-4 flex flex-col gap-2">
                                <h3 class="font-semibold text-sm md:text-base text-gray-900 line-clamp-2">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-xs text-gray-500">
                                    Oleh: <span class="font-medium text-gray-700">{{ $course->teacher->name ?? '-' }}</span>
                                </p>

                                <div class="flex items-center justify-between text-[11px] text-gray-500 mt-2">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-clock text-[10px] text-primary-500"></i>
                                        <span>{{ $course->duration ?? '4 jam' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-star text-[10px] text-yellow-400"></i>
                                        <span class="text-gray-700">4.8</span>
                                    </div>
                                </div>

                                <a href="{{ route('courses.detail', $course->id) }}"
                                    class="mt-3 inline-flex items-center justify-center w-full py-2.5 rounded-2xl bg-primary-500 text-white text-xs md:text-sm font-medium transition-all duration-300 group-hover:bg-primary-600 group-hover:-translate-y-0.5">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    <section class="max-w-6xl mx-auto px-6 mb-10">
        <div class="bg-white rounded-3xl shadow-soft-card p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Filter Kursus</h2>
            </div>

            <form method="GET" action="{{ route('home') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category"
                            class="w-full p-3 border border-neutral-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/70 text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (string)$categoryId === (string)$cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                    <select name="type"
                            class="w-full p-3 border border-neutral-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/70 text-sm">
                        <option value="">Semua Jenis</option>
                        <option value="gratis">Gratis</option>
                        <option value="berbayar">Berbayar</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Topik</label>
                    <input
                        type="text"
                        name="topic"
                        placeholder="Mis: UI/UX, Backend..."
                        class="w-full p-3 border border-neutral-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500/70 text-sm"
                    >
                </div>

                <div class="md:col-span-4 flex justify-end pt-1">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white font-medium py-2.5 px-6 rounded-full text-sm transition-all duration-300 hover:-translate-y-0.5">
                        <i class="fas fa-filter text-xs"></i>
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </section>

        <section class="space-y-4 mt-4">
            <div class="flex items-center justify-between" data-aos="fade-up">
                <h2 class="text-lg md:text-xl font-bold text-gray-900">
                    Semua Kursus
                </h2>
                <p class="text-xs text-gray-500">
                    Menampilkan semua kursus berdasarkan filter yang dipilih.
                </p>
            </div>

            @if ($courses->isEmpty())
                <div class="bg-white rounded-2xl shadow-soft-card p-6 text-center" data-aos="fade-up">
                    <p class="text-gray-500 text-sm">
                        Tidak ada kursus yang cocok dengan filter yang dipilih.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($courses as $index => $course)
                        <div class="bg-white rounded-2xl overflow-hidden shadow-soft-card
                                    hover:shadow-lg transition-all duration-300 hover:-translate-y-1"
                                data-aos="fade-up"
                                data-aos-delay="{{ 50 + ($index % 6) * 60 }}">
                            <div class="relative h-28 bg-gradient-to-tr from-primary-500 to-secondary-500">
                                <div class="absolute inset-0 opacity-25 bg-[radial-gradient(circle_at_top,_#ffffff_0,_transparent_55%)]"></div>

                                <div class="absolute top-2 left-2 bg-white/90 text-primary-500 px-2 py-0.5 rounded-full text-[10px] font-semibold">
                                    {{ $course->category->name ?? 'Umum' }}
                                </div>
                            </div>

                            <div class="p-3 flex flex-col gap-1.5">
                                <h3 class="font-semibold text-sm text-gray-900 line-clamp-2">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-[11px] text-gray-500">
                                    Oleh: <span class="font-medium text-gray-700">{{ $course->teacher->name ?? '-' }}</span>
                                </p>

                                <div class="flex items-center justify-between text-[11px] text-gray-500 mt-1.5">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-users text-[10px] text-primary-500"></i>
                                        <span>{{ $course->students_count }} peserta</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="fas fa-clock text-[10px] text-primary-500"></i>
                                        <span>{{ $course->duration ?? '4 jam' }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('courses.detail', $course->id) }}"
                                    class="mt-2 inline-flex items-center justify-center w-full py-2 rounded-xl
                                            bg-primary-500 text-white text-[11px] font-medium
                                            transition-all duration-300 hover:bg-primary-600 hover:-translate-y-0.5">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="space-y-5" data-aos="fade-up">
            <div class="text-center mb-3">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">F A Q</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Masih bingung? Coba cek beberapa pertanyaan berikut.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-soft-card p-6 md:p-7 space-y-3 max-w-4xl mx-auto">
                <details class="group border border-neutral-100 rounded-2xl px-4 py-3">
                    <summary class="flex items-center justify-between cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-800">
                            Bagaimana cara mengikuti course di Chills Kursus?
                        </span>
                        <span class="ml-3 rounded-full w-7 h-7 flex items-center justify-center bg-primary-50 text-primary-500 text-xs group-open:rotate-180 transition-transform">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        Kamu cukup membuat akun, login, lalu pilih course yang diinginkan. Setelah itu kamu bisa langsung
                        mengakses fitur yang tersedia pada course tersebut.
                    </p>
                </details>

                <details class="group border border-neutral-100 rounded-2xl px-4 py-3">
                    <summary class="flex items-center justify-between cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-800">
                            Apakah semua course berbayar?
                        </span>
                        <span class="ml-3 rounded-full w-7 h-7 flex items-center justify-center bg-primary-50 text-primary-500 text-xs group-open:rotate-180 transition-transform">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        Tidak. Beberapa course tersedia secara gratis, dan sebagian lainnya berbayar. Kamu bisa menggunakan
                        filter <strong>Jenis</strong> pada bagian filter untuk menampilkan course gratis saja.
                    </p>
                </details>

                <details class="group border border-neutral-100 rounded-2xl px-4 py-3">
                    <summary class="flex items-center justify-between cursor-pointer list-none">
                        <span class="text-sm font-semibold text-gray-800">
                            Apakah saya akan mendapatkan sertifikat setelah menyelesaikan course?
                        </span>
                        <span class="ml-3 rounded-full w-7 h-7 flex items-center justify-center bg-primary-50 text-primary-500 text-xs group-open:rotate-180 transition-transform">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </summary>
                    <p class="mt-3 text-sm text-gray-600">
                        Ya, untuk course tertentu kamu akan mendapatkan sertifikat penyelesaian yang bisa digunakan
                        sebagai bukti belajar dan ditambahkan ke CV atau profil profesionalmu.
                    </p>
                </details>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white pt-10 pb-6 mt-4">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div data-aos="fade-up">
                    <h3 class="text-lg font-bold mb-3">Bwakekoqq</h3>
                    <p class="text-gray-400 text-sm">
                        Platform kursus online terpercaya untuk meningkatkan skill dan karir Anda.
                    </p>
                </div>

                <div data-aos="fade-up" data-aos-delay="80">
                    <h4 class="font-semibold mb-3 text-sm">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kursus</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <div data-aos="fade-up" data-aos-delay="140">
                    <h4 class="font-semibold mb-3 text-sm">Kategori</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        @foreach ($categories->take(5) as $cat)
                            <li><a href="#" class="hover:text-white transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div data-aos="fade-up" data-aos-delay="200">
                    <h4 class="font-semibold mb-3 text-sm">Ikuti Kami</h4>
                    <div class="flex gap-4 text-gray-400 text-lg">
                        <a href="#" class="hover:text-white transition-colors"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="hover:text-white transition-colors"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-white transition-colors"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-4 text-center text-gray-500 text-xs">
                &copy; 2025 Chills Kursus Platform. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                offset: 60,
            });
        });
    </script>
</body>
</html>