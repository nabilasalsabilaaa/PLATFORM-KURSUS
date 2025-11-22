<nav>
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 16px; background-color: #f3f3f3;">
        {{-- Kiri: Logo / Nama Aplikasi --}}
        <div>
            <a href="/" style="text-decoration: none; font-weight: bold;">
    MyPlatform
</a>

        </div>

        {{-- Tengah: Menu utama --}}
        <div>
            <a href="/" style="text-decoration: none; font-weight: bold;">
    MyPlatform
</a>


            <a href="{{ route('courses.catalog') }}" style="margin-right: 10px;">
                Course Catalog
            </a>

            @auth
                <a href="{{ route('dashboard') }}" style="margin-right: 10px;">
                    Dashboard
                </a>

                @if (Auth::user()->role === 'teacher')
                    <a href="{{ route('profile.teacher') }}" style="margin-right: 10px;">
                        Teacher Dashboard
                    </a>
                @endif

                @if (Auth::user()->role === 'student')
                    <a href="{{ route('profile.student') }}" style="margin-right: 10px;">
                        My Learning
                    </a>
                @endif

                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" style="margin-right: 10px;">
                        User Management
                    </a>
                @endif
            @endauth
        </div>

        {{-- Kanan: Auth / User info --}}
        <div>
            @auth
                <span style="margin-right: 10px;">
                    {{ Auth::user()->name }}
                </span>

                <a href="{{ route('profile.edit') }}" style="margin-right: 10px;">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: red; cursor: pointer;">
                        Log Out
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" style="margin-right: 10px;">
                    Login
                </a>
                <a href="{{ route('register') }}">
                    Register
                </a>
            @endguest
        </div>
    </div>
    <hr>
</nav>
