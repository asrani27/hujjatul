<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 14px;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 150px;
            height: 250px;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            max-height: 100px;
        }

        .header-content {
            margin-left: 100px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 1px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 1px 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 12px;
            margin: 3px 0;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0 20px 0;
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul h4 {
            margin: 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        table th {
            font-weight: bold;
            font-size: 12px;
        }

        .ttd {
            width: 300px;
            float: right;
            margin-top: 40px;
            text-align: left;
        }

        .ttd p {
            margin: 3px 0;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">

            <div class="logo">
                <img src="{{ base_path('public/logo/tanbu.png') }}" width="80px">
            </div>

            <div class="header-text">
                <h2>KANTOR DESA KERSIK PUTIH KECAMATAN BATULICIN</h2>
                <h3>KABUPATEN TANAH BUMBU</h3>
                <p>Jl. Dharma Praja RT. 08 Kec. Batulicin, Kab. Tanah Bumbu</p>
                <p>Kalimantan Selatan</p>
            </div>

        </div>

        <div class="line"></div>

        <div class="judul">
            <h4>LAPORAN DATA PENGAJUAN</h4>
            <h4>PERIODE : {{ date('Y') }}</h4>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 25px;">No</th>
                    <th style="width: 60px;">Nomor</th>
                    <th style="width: 100px;">Pemohon</th>
                    <th style="width: 80px;">Layanan</th>
                    <th style="width: 60px;">Tanggal</th>
                    <th style="width: 50px;">Status</th>
                    <th>Riwayat Status</th>
                    <th style="width: 150px;">Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data ?? [] as $i => $row)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $row->nomor }}</td>
                    <td>{{ $row->penduduk ? $row->penduduk->nama_lengkap : '-' }}</td>
                    <td>{{ $row->layanan ? $row->layanan->nama : '-' }}</td>
                    <td>{{ $row->tanggal ? $row->tanggal->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if($row->status === 'menunggu')
                        <span class="badge badge-menunggu">Menunggu</span>
                        @elseif($row->status === 'diproses')
                        <span class="badge badge-diproses">Diproses</span>
                        @elseif($row->status === 'selesai')
                        <span class="badge badge-selesai">Selesai</span>
                        @elseif($row->status === 'ditolak')
                        <span class="badge badge-ditolak">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($row->statusHistories && $row->statusHistories->count() > 0)
                        <div class="status-history">
                            @foreach($row->statusHistories->sortBy('created_at') as $history)
                            <div class="status-history-item">
                                <strong>{{ ucfirst($history->status) }}</strong><br>
                                {{ $history->created_at->format('d-m-Y H:i') }}
                            </div>
                            @endforeach
                        </div>
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $row->keterangan ?: '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="ttd">
            <p>Batulicin, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Mengetahui,</p>
            <p>Kepala Desa</p>

            <br><br><br>

            <p><b>{{ $profil->nama_kepala_desa ?? '-' }}</b></p>
            @if($profil->nip_kepala_desa)
            <p>NIP. {{ $profil->nip_kepala_desa }}</p>
            @endif
        </div>

    </div>

</body>

</html>