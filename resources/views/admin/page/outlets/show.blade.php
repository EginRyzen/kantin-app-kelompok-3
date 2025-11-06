@extends('admin.layouts.app')

@section('title', 'Detail Outlet: ' . $outlet->nama_outlet)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Detail Outlet
        </h1>
        <a href="{{ route('admin.outlets.index') }}" class="text-green-600 hover:text-green-800 font-medium">
            &larr; Kembali ke Daftar Outlet
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $outlet->nama_outlet }}</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $outlet->alamat }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm">
                                @if($outlet->is_active == 1)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terdaftar Sejak</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $outlet->created_at->format('d F Y') }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        Daftar Kasir Terdaftar di Outlet Ini
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Lengkap
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Username
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse($outlet->cashiers as $kasir)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $kasir->nama_lengkap }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $kasir->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $kasir->username }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        Belum ada kasir yang terdaftar di outlet ini.
                                    </td>
                                </tr>
                            @endforelse
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
@endsection