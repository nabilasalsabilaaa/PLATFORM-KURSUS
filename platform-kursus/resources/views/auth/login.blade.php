<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bwakekoqq Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</head>
<body class="bg-primary-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-6xl w-full bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">
        <div class="hidden md:flex md:w-1/2 relative bg-gradient-to-br from-primary-500 to-secondary-500 overflow-hidden">
            <img 
                src="" 
                alt="foto login" 
                class="w-full h-full object-cover opacity-90"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute inset-0 p-8 flex flex-col justify-between text-white">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold">Chills Kursus</h1>
                </div>
                
                <div class="mb-12">
                    <h2 class="text-3xl font-bold mb-4">Selamat Datang Kembali!</h2>
                    <p class="text-lg max-w-md">
                        Masuk ke akun Anda untuk melanjutkan pembelajaran
                    </p>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="max-w-md mx-auto w-full">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">Masuk ke Akun</h1>

                @if (session('status'))
                    <div class="bg-secondary-50 border-l-4 border-secondary-500 text-secondary-700 p-4 mb-6 rounded" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <i class="fas fa-check-circle text-secondary-500 mr-3"></i>
                            </div>
                            <div>
                                <p class="font-medium">Berhasil!</p>
                                <p>{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            </div>
                            <div>
                                <p class="font-medium">Terjadi Kesalahan</p>
                                <ul class="list-disc list-inside mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="block w-full pl-10 pr-10 py-3 border border-neutral-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300"
                                placeholder="Masukkan kata sandi">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                id="remember_me"
                                name="remember"
                                type="checkbox"
                                class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium transition duration-300">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-300">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-primary-500 hover:text-primary-600 transition duration-300">
                            Daftar di sini
                        </a>
                    </p>
                </div>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Atau masuk dengan</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-300">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            Google
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-300">
                            <i class="fab fa-facebook-f text-blue-600 mr-2"></i>
                            Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>