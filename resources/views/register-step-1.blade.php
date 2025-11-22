<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Outlet - Step 1</title>
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
            <img src="https://cdn-icons-png.flaticon.com/512/3076/3076935.png" 
                 alt="Store Icon" 
                 class="w-20 h-20 float drop-shadow-lg">
        </div>

        <h2 class="text-4xl font-extrabold text-center text-green-700 mb-10 tracking-wide drop-shadow-sm">
            Registrasi Outlet 🏪
        </h2>

        <p class="text-center text-green-700/80 mb-10 font-medium">
            Langkah 1: Daftarkan data outlet atau toko Anda.
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

        <form method="POST" action="{{ route('register.step1.post') }}" class="space-y-8">
            @csrf

            <div>
                <label for="nama_outlet" class="block mb-3 text-sm font-semibold text-green-800">
                    Nama Outlet
                </label>
                <input 
                    type="text" 
                    id="nama_outlet" 
                    name="nama_outlet"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Contoh: Warung Sejahtera" 
                    value="{{ old('nama_outlet') }}" 
                    required 
                    autofocus>
            </div>

            <div>
                <label for="alamat" class="block mb-3 text-sm font-semibold text-green-800">
                    Alamat Outlet
                </label>
                <textarea 
                    id="alamat" 
                    name="alamat"
                    rows="3"
                    class="bg-green-50 border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-3"
                    placeholder="Masukkan alamat lengkap outlet" 
                    required>{{ old('alamat') }}</textarea>
            </div>

            <div class="pt-4">
                <button 
                    type="submit"
                    class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-base px-6 py-3 transition-all duration-300 shadow-md hover:shadow-lg hover:scale-[1.02]">
                    Lanjut ke Step 2 ➡️
                </button>
            </div>

            <p class="text-sm text-green-700 text-center mt-8">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline">
                    Masuk di sini
                </a>
            </p>
        </form>
    </div>

</body>
</html>