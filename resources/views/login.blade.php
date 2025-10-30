
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kantin App - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(120deg, #0af10aff, #12f94cff, #3ef10cff);
      background-size: 200% 200%;
      animation: gradientShift 10s ease infinite;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      transition: background 0.5s ease;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .particle {
      position: absolute;
      width: 6px;
      height: 6px;
      background: rgba(100, 200, 100, 0.4);
      border-radius: 50%;
      animation: floatParticle linear infinite;
      filter: blur(1px);
    }

    @keyframes floatParticle {
      from { transform: translateY(100vh) scale(0.8); opacity: 0; }
      50% { opacity: 0.8; }
      to { transform: translateY(-10vh) scale(1.1); opacity: 0; }
    }

    .glass {
      background: rgba(89, 248, 16, 0.8);
      backdrop-filter: blur(20px);
      border-radius: 1.5rem;
      box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease-in-out;
      z-index: 10;
    }

    .glass:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 50px rgba(0, 0, 0, 0.1);
    }

    .btn-green {
      background: linear-gradient(to right, #a4f3a4, #b6f5b6);
    }

    .btn-green:hover {
      background: linear-gradient(to right, #93ec93, #a7f3a7);
    }

    @media (prefers-color-scheme: dark) {
      body {
        background: linear-gradient(120deg, #1e2b1e, #284228, #1e2b1e);
        background-size: 200% 200%;
        animation: gradientShift 14s ease infinite;
      }

      .particle {
        background: rgba(160, 255, 160, 0.25);
      }

      .glass {
        background: rgba(20, 35, 20, 0.75);
        border: 1px solid rgba(80, 120, 80, 0.3);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
      }

      .btn-green {
        background: linear-gradient(to right, #3ba53b, #4fba4f);
        color: white;
      }
    }

    @media (max-width: 640px) {
      .glass {
        width: 90%;
        padding: 1.5rem !important;
      }
      .glass h2 { font-size: 1.3rem; }
    }
  </style>
</head>

<body>
  <script>
    for (let i = 0; i < 20; i++) {
      const dot = document.createElement('div');
      dot.classList.add('particle');
      dot.style.left = Math.random() * 100 + '%';
      dot.style.animationDuration = 8 + Math.random() * 10 + 's';
      dot.style.animationDelay = Math.random() * 10 + 's';
      document.body.appendChild(dot);
    }
  </script>

  <div class="glass w-full max-w-sm p-8 sm:p-10 text-center">
    <div class="flex flex-col items-center mb-6">
      <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center mb-4 shadow-inner">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="1.5" stroke="#2e7d32" class="w-8 h-8 sm:w-10 sm:h-10">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 1 1 15 0H4.5Z" />
        </svg>
      </div>
      <h2 class="text-xl sm:text-2xl font-bold text-green-800">Selamat Datang</h2>
      <p class="text-green-700 text-sm">Masuk ke akun Kantin App Anda</p>
    </div>

    <form method="POST" action="{{ route('login.post') }}">
      @csrf

      <div class="mb-4 text-left">
        <label for="username" class="block mb-2 text-sm font-medium text-green-800">Username</label>
        <input type="text" id="username" name="username"
          class="bg-white/70 border border-green-100 text-gray-800 text-sm rounded-full focus:ring-green-400 focus:border-green-400 block w-full p-3"
          placeholder="Masukkan username" required autofocus>
      </div>

      <div class="mb-4 relative text-left">
        <label for="password" class="block mb-2 text-sm font-medium text-green-800">Password</label>
        <input type="password" id="password" name="password"
          class="bg-white/70 border border-green-100 text-gray-800 text-sm rounded-full focus:ring-green-400 focus:border-green-400 block w-full p-3 pr-10"
          placeholder="Masukkan password" required>
        <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 top-7 flex items-center text-green-600">
          <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>
          <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L12 12" />
          </svg>
        </button>
      </div>

      <div class="flex items-center justify-between mb-5">
        <label for="remember" class="flex items-center text-sm text-green-700">
          <input id="remember" name="remember" type="checkbox"
            class="w-4 h-4 text-green-600 bg-white/70 border-gray-300 rounded focus:ring-green-400 focus:ring-2">
          <span class="ml-2">Ingat saya</span>
        </label>
        <a href="#" class="text-sm text-green-600 hover:text-green-800 transition">Lupa Password?</a>
      </div>

      <button type="submit"
        class="w-full text-white btn-green font-semibold rounded-full text-sm px-5 py-2.5 shadow hover:shadow-md transition">
        Masuk
      </button>

      <p class="text-sm text-green-700 text-center mt-5">
        Belum punya akun?
        <a href="#" class="text-green-800 font-semibold hover:text-green-600 transition">Daftar di sini</a>
      </p>
    </form>
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const iconOpen = document.getElementById('icon-eye-open');
    const iconClosed = document.getElementById('icon-eye-closed');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      iconOpen.classList.toggle('hidden');
      iconClosed.classList.toggle('hidden');
    });
  </script>
</body>
</html>
