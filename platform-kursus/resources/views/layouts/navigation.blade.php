<nav>
    <div style="
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        padding: 8px 16px; 
        background-color: #f3f3f3;
    ">
        <div>
            <a href="/" style="text-decoration: none; font-weight: bold;">
                Bwakekoqq Stud
            </a>
        </div>
        <div>
            <a href="{{ route('courses.catalog') }}" style="margin-right: 12px;">
                Course Catalog
            </a>
            @auth
                @if (Auth::user()->role === 'teacher')
                    <a href="{{ route('profile.teacher') }}" style="margin-right: 12px;">
                        Teacher Dashboard
                    </a>
                @endif
                @if (Auth::user()->role === 'student')
                    <a href="{{ route('profile.student') }}" style="margin-right: 12px;">
                        My Learning
                    </a>
                @endif
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" style="margin-right: 12px;">
                        User Management
                    </a>
                    <a href="{{ route('categories.index') }}" style="margin-right: 12px;">
                        Categories
                    </a>
                @endif
                <a href="{{ route('dashboard') }}" style="margin-right: 12px;">
                    Dashboard
                </a>
            @endauth
        </div>
        <div>
            @auth
                <span style="margin-right: 12px;">
                    {{ Auth::user()->name }}
                </span>

                <a href="{{ route('profile.edit') }}" style="margin-right: 12px;">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                            style="background:none; border:none; color:red; cursor:pointer;">
                        Log Out
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" style="margin-right: 12px;">
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