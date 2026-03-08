@extends('layouts.app')

@section('title', 'Dashboard - Hujjatul')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-800">{{ $penduduk->nama_lengkap }}</h3>
                <p class="text-sm text-gray-600">NIK: {{ $penduduk->nik }}</p>
                <p class="text-sm text-gray-600">{{ $penduduk->desa }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Pengajuan -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Pengajuan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPengajuan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Menunggu -->
        <div class="bg-gray-50 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Menunggu</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pengajuanMenunggu }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Diproses -->
        <div class="bg-blue-50 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Diproses</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pengajuanDiproses }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-green-50 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Selesai</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pengajuanSelesai }}</p>
                </div>
                <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="bg-red-50 rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Ditolak</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pengajuanDitolak }}</p>
                </div>
                <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Pengajuan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pengajuan Saya</h3>
            <a href="{{ route('masyarakat.pengajuan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Lihat Semua</a>
        </div>
        <div class="space-y-3">
            @forelse($recentPengajuan as $pengajuan)
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ $pengajuan->layanan ? $pengajuan->layanan->nama : '-' }}</p>
                    <p class="text-xs text-gray-500">No. {{ $pengajuan->nomor }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium 
                        @if($pengajuan->status === 'menunggu') bg-gray-100 text-gray-800
                        @elseif($pengajuan->status === 'diproses') bg-blue-100 text-blue-800
                        @elseif($pengajuan->status === 'selesai') bg-green-100 text-green-800
                        @elseif($pengajuan->status === 'ditolak') bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($pengajuan->status) }}
                    </span>
                    <p class="text-xs text-gray-400 mt-1">{{ $pengajuan->created_at ? $pengajuan->created_at->diffForHumans() : '-' }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada pengajuan</p>
            @endforelse
        </div>
    </div>
</div>
@endsection