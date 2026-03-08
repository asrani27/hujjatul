@extends('layouts.app')

@section('title', 'Detail Pengajuan - Hujjatul')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan</h1>
            <p class="text-gray-600 mt-1">Nomor: {{ $pengajuan->nomor }}</p>
        </div>
        <a href="{{ route('masyarakat.pengajuan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Alert Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Status Card -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Status Saat Ini</h3>
                <p class="text-sm text-gray-500 mt-1">Terakhir diperbarui: {{ $pengajuan->updated_at ? $pengajuan->updated_at->format('d-m-Y H:i:s') : '-' }}</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold 
                    @if($pengajuan->status === 'menunggu') bg-gray-100 text-gray-800
                    @elseif($pengajuan->status === 'diproses') bg-blue-100 text-blue-800
                    @elseif($pengajuan->status === 'selesai') bg-green-100 text-green-800
                    @elseif($pengajuan->status === 'ditolak') bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($pengajuan->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Informasi Pengajuan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Detail Pengajuan -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengajuan</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Nomor Pengajuan</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->nomor }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Layanan</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->layanan ? $pengajuan->layanan->nama : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Tanggal Pengajuan</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->tanggal ? $pengajuan->tanggal->format('d-m-Y') : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Nama Pemohon</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->penduduk ? $pengajuan->penduduk->nama_lengkap : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">NIK</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->penduduk ? $pengajuan->penduduk->nik : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Desa</span>
                    <span class="text-sm font-medium text-gray-900">{{ $pengajuan->penduduk ? $pengajuan->penduduk->desa : '-' }}</span>
                </div>
                @if($pengajuan->keterangan)
                <div>
                    <span class="text-sm text-gray-500 block mb-1">Keterangan</span>
                    <p class="text-sm text-gray-900">{{ $pengajuan->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Dokumen -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Dokumen Pendukung</h3>
            @if($pengajuan->dokumen && $pengajuan->dokumen->count() > 0)
            <div class="space-y-3">
                @foreach($pengajuan->dokumen as $dokumen)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $dokumen->nama_file }}</p>
                        </div>
                    </div>
                    <a href="{{ route('masyarakat.pengajuan.download-dokumen', $dokumen) }}" 
                       class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Download
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500 text-center py-4">Tidak ada dokumen yang diunggah</p>
            @endif
        </div>
    </div>

    <!-- Riwayat Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Status</h3>
        @if($pengajuan->statusHistories && $pengajuan->statusHistories->count() > 0)
        <div class="space-y-4">
            @foreach($pengajuan->statusHistories as $index => $history)
            <div class="flex items-start">
                <!-- Timeline Line -->
                <div class="flex flex-col items-center mr-4">
                    @if($index === 0)
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    @elseif($index < $pengajuan->statusHistories->count() - 1)
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    @else
                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    @endif
                    @if($index < $pengajuan->statusHistories->count() - 1)
                    <div class="w-0.5 h-full bg-gray-200 mt-2"></div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="flex-1 pb-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium 
                            @if($history->status === 'menunggu') bg-gray-100 text-gray-800
                            @elseif($history->status === 'diproses') bg-blue-100 text-blue-800
                            @elseif($history->status === 'selesai') bg-green-100 text-green-800
                            @elseif($history->status === 'ditolak') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($history->status) }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $history->created_at ? $history->created_at->format('d-m-Y H:i:s') : '-' }}
                        </span>
                    </div>
                    @if($history->keterangan)
                    <p class="text-sm text-gray-600 mt-2">{{ $history->keterangan }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat status</p>
        @endif
    </div>
</div>
@endsection