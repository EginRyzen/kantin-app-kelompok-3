@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">
        Selamat Datang, Admin Dashboard!
    </h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-gray-700">
            Ini adalah halaman dashboard admin. Anda bisa mengelola user, melihat laporan,
            dan mengatur konten dari sini.
        </p>
    </div>
@endsection