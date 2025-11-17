<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Step 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float { animation: float 4s ease-in-out infinite; }
        .glow { box-shadow: 0 0 25px rgba(16, 185, 129, 0.3); }
    </style>
</head>

<body class="bg-gradient-to-br from-green-50 via-emerald-100 to-green-200 flex items-center justify-center min-h-screen py-24 px-6">

    <div class="w-full max-w-md bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl glow p-12 border border-green-200 transition-all duration-300">
        
        <div class="flex justify-center mb-6">
            <img src="https://cdn-icons-png.flaticon.com/512/4333/4333609.png" 
                 alt="User Icon" 
                 class="w-20 h-20 float drop-shadow-lg">
        </div>

        <h2 class="text-4xl font-extrabold text-center text-green-700 mb-10 tracking-wide drop-shadow-sm">
            Akun Kasir Anda 👤
        </h2>

        <p class="text-center text-green-700/80 mb-10 font-medium">
            Langkah 2: Buat akun untuk login sebagai kasir.
        </p>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <div class="text-sm font-semibold space-y-1">
                    @foreach ($errors->all() as $error)
                        <span class="block">{{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('register.step2.post') }}" class="space-y-8">
            @csrf

            <div>
                <label for="nama_lengkap" class="block mb-3 text-sm font-semibold text-green-800">
                    Nama Lengkap
                </label>
                <input 
                    type="text" 
                    id="nama_lengkap" 
                    name="nama_lengkap"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Masukkan nama lengkap Anda" 
                    value="{{ old('nama_lengkap') }}" 
                    required 
                    autofocus>
            </div>

            <div>
                <label for="username" class="block mb-3 text-sm font-semibold text-green-800">
                    Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Buat username untuk login" 
                    value="{{ old('username') }}" 
                    required>
            </div>

            <div>
                <label for="email" class="block mb-3 text-sm font-semibold text-green-800">
                    Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="email@anda.com" 
                    value="{{ old('email') }}" 
                    required>
            </div>

            <div class="relative">
                <label for="password" class="block mb-3 text-sm font-semibold text-green-800">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3 pr-10"
                    placeholder="Buat password (min. 8 karakter)" 
                    required>
                </div>
            
            <div>
                <label for="password_confirmation" class="block mb-3 text-sm font-semibold text-green-800">
                    Konfirmasi Password
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Ulangi password Anda" 
                    required>
            </div>


            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-base px-6 py-3 transition-all duration-300 shadow-md hover:shadow-lg hover:scale-[1.02]">
                    Daftar Sekarang 🚀
                </button>
            </div>

            <p class="text-sm text-green-700 text-center mt-8">
                Salah data outlet?
                <a href="{{ route('register.step1') }}" class="text-green-700 font-semibold hover:underline">
                    Kembali ke Step 1
                </a>
            </p>
        </form>
    </div>
    
    </body>
</html>