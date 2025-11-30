<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Chills Kursus'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
                    }
                }
            }
        }
    </script>

    
    <style>
        .nav-link {
            position: relative;
            padding: 4px 8px;      
            color: #4B5563;
            font-weight: 500;
            font-size: 0.82rem;       
            white-space: nowrap;      
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: #716bf0;
        }
        
        .nav-link.active {
            color: #716bf0;
        }

        .mobile-nav-link {
            display: block;
            padding: 12px 0;
            color: #4B5563;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
            border-bottom: 1px solid #e4e6ee;
        }
        
        .mobile-nav-link:hover {
            color: #716bf0;
        }
        
        .mobile-nav-link.active {
            color: #716bf0;
            border-bottom: 3px solid #716bf0;
        }
        
        .mobile-nav-link:last-child {
            border-bottom: none;
        }

        #active-indicator {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: left;
        }
    </style>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-primary-50 text-gray-900 min-h-screen">
    <div class="hidden bg-primary-500 bg-primary-600 text-primary-500"></div>
    <nav class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-primary-50 shadow-sm relative">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex justify-between items-center py-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" 
                    alt="Logo"
                    class="w-10 h-10 object-contain">
                <div>
                    <a href="{{ url('/') }}" class="text-xl font-bold text-primary-600 tracking-tight no-underline">
                        Chills Kursus
                    </a>
                    <p class="text-xs text-gray-500 -mt-0.5 hidden sm:block">
                        Find your favorite course
                    </p>
                </div>
            </div>

            <div class="hidden md:flex items-center space-x-1 " id="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}" 
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        data-route="dashboard">
                        Dashboard
                    </a>
                @endauth

                <a href="{{ route('courses.catalog') }}" 
                    class="nav-link {{ request()->routeIs('courses.catalog') ? 'active' : '' }}"
                    data-route="courses.catalog">
                    Course Catalog
                </a>

                @auth
                    @if (Auth::user()->role === 'teacher')
                        <a href="{{ route('courses.index') }}" 
                            class="nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}"
                            data-route="courses.index">
                            My Courses
                        </a>
                    @endif

                    @if (Auth::user()->role === 'student')
                        <a href="{{ route('profile.student') }}" 
                            class="nav-link {{ request()->routeIs('profile.student') ? 'active' : '' }}"
                            data-route="profile.student">
                            My Courses
                        </a>
                    @endif

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}" 
                            class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                            data-route="users.index">
                            User Management
                        </a>
                        <a href="{{ route('categories.index') }}" 
                            class="nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                            data-route="categories.index">
                            Categories
                        </a>
                        <a href="{{ route('courses.index') }}" 
                            class="nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}"
                            data-route="courses.index">
                            Courses Management
                        </a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <div class="hidden md:flex items-center gap-2">
                        <div class="w-9 h-9 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="text-sm text-gray-700 hidden lg:inline">
                            Halo, <strong>{{ Auth::user()->name }}</strong>
                        </span>
                    </div>

                    <a href="{{ route('profile.edit') }}" 
                        class="hidden md:inline-flex items-center text-sm font-medium text-primary-500 hover:text-primary-600 transition-colors nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                        data-route="profile.edit">
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 text-sm font-medium text-red-500 hover:text-red-600 transition-colors mb-1">
                            <i class="fas fa-sign-out-alt text-xs mt-1"></i>
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" 
                        class="text-primary-500 hover:text-primary-600 font-medium text-sm transition-colors nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                        data-route="login">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                        class="hidden sm:inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-full text-sm font-medium shadow-md transition-all duration-300 hover:-translate-y-0.5">
                        <i class="fas fa-user-plus text-xs"></i>
                        Register
                    </a>
                @endguest

                <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden hidden py-4 border-t border-neutral-100">
            <div class="flex flex-col space-y-4">
                <a href="{{ route('courses.catalog') }}" 
                    class="mobile-nav-link {{ request()->routeIs('courses.catalog') ? 'active' : '' }}">
                    Course Catalog
                </a>

                @auth
                    @if (Auth::user()->role === 'teacher')
                        <a href="{{ route('courses.index') }}" 
                            class="mobile-nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                            My Courses
                        </a>
                    @endif

                    @if (Auth::user()->role === 'student')
                        <a href="{{ route('profile.student') }}" 
                            class="mobile-nav-link {{ request()->routeIs('profile.student') ? 'active' : '' }}">
                            My Courses
                        </a>
                    @endif

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}" 
                            class="mobile-nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                            User Management
                        </a>
                        <a href="{{ route('categories.index') }}" 
                            class="mobile-nav-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                            Categories
                        </a>
                        <a href="{{ route('courses.index') }}" 
                            class="mobile-nav-link {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                            Courses Management
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}" 
                        class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('profile.edit') }}" 
                        class="mobile-nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        Profile
                    </a>

                    <div class="pt-4 border-t border-neutral-100">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-gray-700">
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="h-1 bg-primary-500" id="active-indicator"></div>
    </nav>

    <div class="min-h-screen">
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif
        
        <main>
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu       = document.getElementById('mobile-menu');
            const nav              = document.querySelector('nav');
            const indicator        = document.getElementById('active-indicator');
            const navLinks         = Array.from(document.querySelectorAll('#nav-links .nav-link'));

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');

                    const icon = this.querySelector('i');
                    if (mobileMenu.classList.contains('hidden')) {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    } else {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    }
                });
            }

            if (!indicator || !nav || navLinks.length === 0) {
                return;
            }

            function setIndicatorInstant(link) {
                if (!link) return;
                const linkRect = link.getBoundingClientRect();
                const navRect  = nav.getBoundingClientRect();

                indicator.style.transition = 'none'; // tanpa animasi
                indicator.style.width      = `${linkRect.width}px`;
                indicator.style.transform  = `translateX(${linkRect.left - navRect.left}px)`;
            }

            function animateIndicatorTo(link) {
                if (!link) return;
                const linkRect = link.getBoundingClientRect();
                const navRect  = nav.getBoundingClientRect();

                indicator.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                indicator.style.width      = `${linkRect.width}px`;
                indicator.style.transform  = `translateX(${linkRect.left - navRect.left}px)`;
            }

            window.addEventListener('resize', function () {
                const activeLink = document.querySelector('.nav-link.active');
                if (activeLink) {
                    setIndicatorInstant(activeLink);
                }
            });
            const LAST_INDEX_KEY = 'nav_last_index';
            navLinks.forEach((link, index) => {
                link.dataset.index = index;
            });

            const storedIndex = parseInt(localStorage.getItem(LAST_INDEX_KEY), 10);
            const fromLink =
                Number.isInteger(storedIndex) && navLinks[storedIndex]
                    ? navLinks[storedIndex]
                    : navLinks[0]; 

            const activeLink = document.querySelector('.nav-link.active') || fromLink;
            setIndicatorInstant(fromLink);
            requestAnimationFrame(() => {
                animateIndicatorTo(activeLink);
            });

            navLinks.forEach(link => {
                link.addEventListener('click', function () {
                    const index = parseInt(this.dataset.index, 10);
                    if (Number.isInteger(index)) {
                        localStorage.setItem(LAST_INDEX_KEY, index);
                    }
                });
            });

            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function () {
                    const href = this.getAttribute('href');
                    if (href && !href.startsWith('#')) {
                        const preloadLink = document.createElement('link');
                        preloadLink.rel  = 'prefetch';
                        preloadLink.href = href;
                        document.head.appendChild(preloadLink);
                    }
                });
            });
        });
    </script>
</body>
</html>
