@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            Dashboard Admin
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m-1 4h1m6-4h1m-1 4h1m-1 4h1m-6-4h1m-1 4h1m-1 4h1" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Outlet Terdaftar</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $totalOutlets ?? '15' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Outlet Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $activeOutlets ?? '12' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Outlet Tidak Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $inactiveOutlets ?? '3' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                Grafik Penjualan (30 Hari Terakhir)
            </h2>
            <div class="h-64 lg:h-80">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <h2 class="text-xl font-semibold text-gray-900 p-6">
                Daftar Outlet
            </h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Outlet
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Penjualan (Hari Ini)
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                        {{-- Contoh data dummy - Ganti dengan @foreach($outlets as $outlet) dari controller --}}
                        
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Kantin Sehat Bu Ida</div>
                                <div class="text-sm text-gray-500">Gedung A Lt. 1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp 1.500.000</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Warung Kopi Senja</div>
                                <div class="text-sm text-gray-500">Gedung Rektorat</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Tidak Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp 0</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Nasi Goreng Pak Kumis</div>
                                <div class="text-sm text-gray-500">Area Food Court</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp 950.000</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>

                        {{-- Akhir dari loop @foreach --}}

                    </tbody>
                </table>
            </div>
            
            {{-- <div class="p-6">
                {{ $outlets->links() }}
            </div> --}}

        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data ini idealnya dilempar dari Controller
    const salesData = {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'], // Contoh 7 hari
        datasets: [{
            label: 'Penjualan Minggu Ini',
            data: [120, 190, 300, 500, 200, 350, 400], // Contoh data
            backgroundColor: 'rgba(79, 70, 229, 0.2)', // Indigo-200
            borderColor: 'rgba(79, 70, 229, 1)',     // Indigo-600
            borderWidth: 2,
            tension: 0.3
        }]
    };

    const ctx = document.getElementById('salesChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line', // Tipe grafik (bisa 'bar', 'line', 'pie', etc.)
        data: salesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush