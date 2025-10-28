@extends('user.layouts.app')

@section('title', 'Selamat Datang di Kantin App')

@section('content')
<section class="relative overflow-hidden bg-white">
    <div class="absolute top-0 right-0 w-full h-full bg-green-100 rounded-bl-[60px] md:rounded-bl-[100px] -z-10"></div>

    <div class="container mx-auto px-4 sm:px-6 py-16 sm:py-24 text-center">
        <p class="text-gray-500 text-base sm:text-lg font-medium mb-2 sm:mb-3">Lapar?</p>
        <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 leading-snug sm:leading-tight">
            Sini ke <span class="text-green-600">Kantin App</span><br class="hidden sm:block"> & Pilih Favoritmu.
        </h1>
        <p class="text-gray-600 mt-4 sm:mt-6 max-w-xl sm:max-w-2xl mx-auto text-sm sm:text-base">
            Pilih berbagai menu lezat ala kantin kampus! Cepat, enak, dan hemat.<br class="hidden sm:block">
            Pesan sekarang dan nikmati hidangan favoritmu hari ini juga!
        </p>

        <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
            <button class="bg-green-600 text-white px-6 sm:px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition">
                Pesan Sekarang
            </button>
            <button class="border border-green-600 text-green-700 px-6 sm:px-8 py-3 rounded-full font-semibold hover:bg-green-50 transition">
                Jelajahi Menu
            </button>
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Menu Favorit Kami</h2>
        <p class="text-gray-600 mb-12 text-lg">Nikmati hidangan lezat yang paling banyak dipesan di KantinApp!</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-2xl transform hover:-translate-y-2 transition duration-300">
                <img src="https://placehold.co/200x200/FACC15/333?text=Nasi+Goreng"
                    class="w-40 h-40 object-cover mx-auto rounded-full mb-4 ring-4 ring-green-100">
                <h3 class="text-xl font-bold text-gray-800">Nasi Goreng Spesial</h3>
                <p class="text-gray-500 text-sm mt-2">Nasi goreng lezat dengan telur, ayam, dan sayuran segar.</p>
                <div class="mt-5">
                    <p class="text-green-700 font-semibold mb-3 text-lg">Rp 25.000</p>
                    <button class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 hover:scale-105 transition duration-300">
                        Pesan Sekarang
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-2xl transform hover:-translate-y-2 transition duration-300">
                <img src="https://placehold.co/200x200/FACC15/333?text=Mie+Ayam"
                    class="w-40 h-40 object-cover mx-auto rounded-full mb-4 ring-4 ring-green-100">
                <h3 class="text-xl font-bold text-gray-800">Mie Ayam Bakso</h3>
                <p class="text-gray-500 text-sm mt-2">Mie kenyal dengan potongan ayam dan bakso gurih.</p>
                <div class="mt-5">
                    <p class="text-green-700 font-semibold mb-3 text-lg">Rp 20.000</p>
                    <button class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 hover:scale-105 transition duration-300">
                        Pesan Sekarang
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-2xl transform hover:-translate-y-2 transition duration-300">
                <img src="https://placehold.co/200x200/FACC15/333?text=Ayam+Bakar"
                    class="w-40 h-40 object-cover mx-auto rounded-full mb-4 ring-4 ring-green-100">
                <h3 class="text-xl font-bold text-gray-800">Ayam Bakar Madu</h3>
                <p class="text-gray-500 text-sm mt-2">Ayam bakar dengan olesan madu yang manis dan gurih.</p>
                <div class="mt-5">
                    <p class="text-green-700 font-semibold mb-3 text-lg">Rp 30.000</p>
                    <button class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 hover:scale-105 transition duration-300">
                        Pesan Sekarang
                    </button>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-6 hover:shadow-2xl transform hover:-translate-y-2 transition duration-300">
                <img src="https://placehold.co/200x200/FACC15/333?text=Es+Teh"
                    class="w-40 h-40 object-cover mx-auto rounded-full mb-4 ring-4 ring-green-100">
                <h3 class="text-xl font-bold text-gray-800">Es Teh Manis</h3>
                <p class="text-gray-500 text-sm mt-2">Minuman segar pelepas dahaga setelah makan.</p>
                <div class="mt-5">
                    <p class="text-green-700 font-semibold mb-3 text-lg">Rp 5.000</p>
                    <button class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 hover:scale-105 transition duration-300">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50 relative overflow-hidden">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-10">Mengapa Memilih Kami?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        
            <div class="group bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                <i class="fas fa-leaf text-green-600 text-4xl mb-5 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="font-bold text-gray-800 mb-2 text-xl group-hover:text-green-700 transition-colors">Makanan Sehat</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Kami menyajikan makanan bergizi dan segar untuk kamu setiap hari.</p>
            </div>

            <div class="group bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                <i class="fas fa-award text-yellow-600 text-4xl mb-5 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="font-bold text-gray-800 mb-2 text-xl group-hover:text-yellow-700 transition-colors">Kualitas Terbaik</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Kami menjaga rasa dan kualitas setiap hidangan yang kami buat.</p>
            </div>

            <div class="group bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-3 transition-all duration-300">
                <i class="fas fa-truck text-green-600 text-4xl mb-5 group-hover:scale-110 transition-transform duration-300"></i>
                <h4 class="font-bold text-gray-800 mb-2 text-xl group-hover:text-green-700 transition-colors">Pengantaran Cepat</h4>
                <p class="text-gray-500 text-sm leading-relaxed">Pesananmu akan sampai dengan cepat dan aman di tanganmu.</p>
            </div>

        </div>
    </div>
</section>
@endsection
