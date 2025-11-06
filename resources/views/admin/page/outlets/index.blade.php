@extends('admin.layouts.app')

@section('title', 'Daftar Outlet')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Daftar Outlet
        </h1>
        </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
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
                    
                    @forelse($outlets as $outlet)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $outlet->nama_outlet }}</div>
                            <div class="text-sm text-gray-500">{{ $outlet->alamat }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($outlet->is_active == 1)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">-</div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.outlets.show', $outlet->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                Lihat Detail
                            </a>

                            <form action="{{ route('admin.outlets.toggleStatus', $outlet->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                
                                @if($outlet->is_active == 1)
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Anda yakin ingin menonaktifkan outlet ini?')">
                                        Nonaktifkan
                                    </button>
                                @else
                                    <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Anda yakin ingin mengaktifkan outlet ini?')">
                                        Aktifkan
                                    </button>
                                @endif
                            </form>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            Belum ada data outlet.
                        </td>
                    </tr>
                    @endforelse
                    
                </tbody>
                </table>
        </div>
    </div>
@endsection