<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float {
            animation: float 4s ease-in-out infinite;
        }

        /* Efek glow halus di sekitar kotak login */
        .glow {
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-green-50 via-emerald-100 to-green-200 flex items-center justify-center min-h-screen py-24 px-6">
<body class="bg-gradient-to-br from-green-50 via-emerald-100 to-green-200 flex items-center justify-center min-h-screen py-24 px-6">

    <div class="w-full max-w-md bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl glow p-12 border border-green-200 transition-all duration-300 hover:shadow-green-300/60 hover:scale-[1.02]">
        
        <!-- Gambar di atas -->
        <div class="flex justify-center mb-6">
            <img src="https://cdn-icons-png.flaticon.com/512/857/857681.png" 
                 alt="Food Icon" 
                 class="w-20 h-20 float drop-shadow-lg">
        </div>

        <!-- Judul -->
        <h2 class="text-4xl font-extrabold text-center text-green-700 mb-10 tracking-wide drop-shadow-sm">
            Selamat Datang 🍱
        </h2>

        <!-- Subteks -->
        <p class="text-center text-green-700/80 mb-10 font-medium">
            Yuk login dulu sebelum menikmati berbagai menu lezat!
        </p>
    <div class="w-full max-w-md bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl glow p-12 border border-green-200 transition-all duration-300 hover:shadow-green-300/60 hover:scale-[1.02]">
        
        <!-- Gambar di atas -->
        <div class="flex justify-center mb-6">
            <img src="https://cdn-icons-png.flaticon.com/512/857/857681.png" 
                 alt="Food Icon" 
                 class="w-20 h-20 float drop-shadow-lg">
        </div>

        <!-- Judul -->
        <h2 class="text-4xl font-extrabold text-center text-green-700 mb-10 tracking-wide drop-shadow-sm">
            Selamat Datang 🍱
        </h2>

        <!-- Subteks -->
        <p class="text-center text-green-700/80 mb-10 font-medium">
            Yuk login dulu sebelum menikmati berbagai menu lezat!
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="text-sm font-semibold space-y-1">
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="text-sm font-semibold space-y-1">
                    @foreach ($errors->all() as $error)
                        <span class="block">{{ $error }}</span>
                        <span class="block">{{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-8">
        <form method="POST" action="{{ route('login.post') }}" class="space-y-8">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block mb-3 text-sm font-semibold text-green-800">
                    Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Masukkan username" 
                    value="{{ old('username') }}" 
                    required 
                    autofocus>
            <!-- Username -->
            <div>
                <label for="username" class="block mb-3 text-sm font-semibold text-green-800">
                    Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Masukkan username" 
                    value="{{ old('username') }}" 
                    required 
                    autofocus>
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block mb-3 text-sm font-semibold text-green-800">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3 pr-10"
                    placeholder="Masukkan password" 
                    required>

                <button 
                    type="button" 
                    id="togglePassword"
                    class="absolute inset-y-0 right-0 top-8 flex items-center px-3 text-green-600">
                    
                    <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                        class="w-5 h-5">
            <!-- Password -->
            <div class="relative">
                <label for="password" class="block mb-3 text-sm font-semibold text-green-800">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3 pr-10"
                    placeholder="Masukkan password" 
                    required>

                <button 
                    type="button" 
                    id="togglePassword"
                    class="absolute inset-y-0 right-0 top-8 flex items-center px-3 text-green-600">
                    
                    <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                        class="w-5 h-5 hidden">

                    <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                        class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L12 12" />
                    </svg>
                </button>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember" class="flex items-center text-sm text-green-700">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox"
                        class="w-4 h-4 text-green-600 bg-green-50 border-green-300 rounded focus:ring-green-500 focus:ring-2">
                    <span class="ml-2">Ingat saya</span>
            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember" class="flex items-center text-sm text-green-700">
                    <input 
                        id="remember" 
                        name="remember" 
                        type="checkbox"
                        class="w-4 h-4 text-green-600 bg-green-50 border-green-300 rounded focus:ring-green-500 focus:ring-2">
                    <span class="ml-2">Ingat saya</span>
                </label>
                <a href="#" class="text-sm text-green-700 hover:underline font-medium">
                    Lupa password?
                </a>
                <a href="#" class="text-sm text-green-700 hover:underline font-medium">
                    Lupa password?
                </a>
            </div>

            <!-- Tombol -->
            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-base px-6 py-3 transition-all duration-300 shadow-md hover:shadow-lg hover:scale-[1.02]">
                    🍔 Masuk Sekarang
                </button>
            </div>
            <!-- Tombol -->
            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-base px-6 py-3 transition-all duration-300 shadow-md hover:shadow-lg hover:scale-[1.02]">
                    🍔 Masuk Sekarang
                </button>
            </div>

            <!-- Link daftar -->
            <p class="text-sm text-green-700 text-center mt-8">
            <!-- Link daftar -->
            <p class="text-sm text-green-700 text-center mt-8">
                Belum punya akun?
                <a href="#" class="text-green-700 font-semibold hover:underline">
                    Daftar di sini
                </a>
                <a href="#" class="text-green-700 font-semibold hover:underline">
                    Daftar di sini
                </a>
            </p>
        </form>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const iconOpen = document.getElementById('icon-eye-open');
        const iconClosed = document.getElementById('icon-eye-closed');

        togglePassword.addEventListener('click', function () {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            iconOpen.classList.toggle('hidden');
            iconClosed.classList.toggle('hidden');
        });
    </script>

</body>

</html>
