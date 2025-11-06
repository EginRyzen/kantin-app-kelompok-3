@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6"> 
    <div class="p-6 rounded-lg shadow-md bg-gradient-to-r from-green-500 to-green-700 text-white">
        <h2 class="text-2xl font-bold">Selamat Datang di Dashboard Admin</h2>
        <p class="mt-1">Kelola semua outlet dan transaksi Anda dengan mudah.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m6-4h1m-1 4h1m-1 4h1m-6-4h1m-1 4h1m-1 4h1" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Outlet Terdaftar</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalOutlets }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Outlet Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ $activeOutlets }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Outlet Tidak Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ $inactiveOutlets }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white shadow-lg rounded-lg p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">
        Grafik Penjualan (7 Hari Terakhir)
    </h2>
    <div class="h-64 lg:h-80">
        <canvas id="salesChart"></canvas>
    </div>
</div>
    
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ======================================================
    // MULAI BAGIAN SCRIPT YANG DIPERBARUI
    // ======================================================

    // 1. Mengambil data dinamis dari DashboardController
    const chartLabels = @json($chartLabels ?? []);
    const chartData = @json($chartData ?? []);

    // 2. Mendefinisikan data untuk Chart.js menggunakan variabel di atas
    const salesData = {
        labels: chartLabels,
        datasets: [{
            label: 'Total Penjualan (Rp)',
            data: chartData,
            // Warna disesuaikan dengan tema hijau Anda
            backgroundColor: 'rgba(75, 192, 192, 0.2)', 
            borderColor: 'rgba(75, 192, 192, 1)',     
            borderWidth: 2,
            tension: 0.3
        }]
    };

    // 3. Merender chart (kode ini tetap sama)
    const ctx = document.getElementById('salesChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: salesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });
    // ======================================================
    // AKHIR BAGIAN SCRIPT YANG DIPERBARUI
    // ======================================================
</script>
@endpush