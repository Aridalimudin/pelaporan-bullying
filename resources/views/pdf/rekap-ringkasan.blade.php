<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'DejaVu Sans', sans-serif; font-size:11px; color:#1f2937; background:#fff; }
    .page { padding:32px 36px; }

    /* Kop */
    .kop { display:table; width:100%; border-bottom:3px double #10b981; padding-bottom:12px; margin-bottom:18px; }
    .kop-logo { display:table-cell; width:70px; vertical-align:middle; }
    .kop-logo img { width:60px; height:60px; }
    .kop-text { display:table-cell; vertical-align:middle; text-align:center; padding:0 8px; }
    .kop-sekolah { font-size:16px; font-weight:bold; color:#111827; line-height:1.2; }
    .kop-alamat  { font-size:9px; color:#6b7280; margin-top:3px; line-height:1.4; }
    .kop-right { display:table-cell; width:70px; vertical-align:middle; text-align:right; }
    .kop-badge { background:#10b981; color:#fff; font-size:8px; font-weight:bold; padding:3px 8px; border-radius:4px; display:inline-block; }
    .kop-date  { font-size:8px; color:#9ca3af; margin-top:4px; }

    /* Info surat */
    .surat-info { margin-bottom:16px; font-size:10px; color:#374151; }
    .surat-info table { width:auto; border-collapse:collapse; }
    .surat-info td { padding:2px 8px 2px 0; vertical-align:top; }
    .surat-info .label { color:#6b7280; width:110px; }
    .surat-info .colon { width:10px; }

    /* Judul */
    .judul-doc { text-align:center; margin-bottom:16px; padding:10px; background:#f0fdf4; border-radius:6px; border:1px solid #d1fae5; }
    .judul-main { font-size:13px; font-weight:bold; color:#065f46; }
    .judul-sub  { font-size:10px; color:#10b981; margin-top:3px; }

    /* Stats */
    .stats-grid { display:table; width:100%; margin-bottom:16px; }
    .stat-cell  { display:table-cell; width:25%; padding:0 4px; }
    .stat-cell:first-child { padding-left:0; }
    .stat-cell:last-child  { padding-right:0; }
    .stat-box { border-radius:8px; padding:12px 10px; text-align:center; border:1.5px solid; }
    .stat-val { font-size:20px; font-weight:bold; display:block; line-height:1; }
    .stat-lbl { font-size:9px; font-weight:bold; display:block; margin-top:3px; opacity:.8; }
    .sb-blue  { background:#eff6ff; border-color:#bfdbfe; color:#3b82f6; }
    .sb-green { background:#ecfdf5; border-color:#a7f3d0; color:#10b981; }
    .sb-red   { background:#fef2f2; border-color:#fecaca; color:#ef4444; }
    .sb-amber { background:#fffbeb; border-color:#fde68a; color:#d97706; }

    /* Progress */
    .progress-wrap { margin-bottom:16px; }
    .progress-label { display:flex; justify-content:space-between; font-size:10px; font-weight:bold; color:#6b7280; margin-bottom:5px; }
    .progress-track { background:#f3f4f6; border-radius:99px; height:10px; }
    .progress-bar   { height:10px; border-radius:99px; }

    /* Section */
    .section-title { font-size:10px; font-weight:bold; color:#9ca3af; text-transform:uppercase; letter-spacing:.05em; margin-bottom:10px; }

    /* Tabel */
    table.data { width:100%; border-collapse:collapse; font-size:10px; margin-top:4px; }
    table.data thead th { background:#f9fafb; padding:8px 10px; text-align:left; font-weight:bold; color:#6b7280; border-bottom:1.5px solid #e5e7eb; border-top:1.5px solid #e5e7eb; }
    table.data tbody td { padding:7px 10px; border-bottom:1px solid #f3f4f6; color:#374151; }
    table.data tbody tr:last-child td { border-bottom:none; }
    table.data tbody tr:nth-child(even) td { background:#fafafa; }

    .badge-pill { display:inline-block; padding:2px 7px; border-radius:99px; font-size:9px; font-weight:bold; }
    .bp-good { background:#ecfdf5; color:#10b981; }
    .bp-mid  { background:#fffbeb; color:#d97706; }
    .bp-low  { background:#fef2f2; color:#ef4444; }

    /* Progress bar mini inline */
    .bar-wrap { width:80px; display:inline-block; vertical-align:middle; }
    .bar-track { background:#f3f4f6; border-radius:99px; height:6px; }
    .bar-fill  { height:6px; border-radius:99px; }

    /* TTD */
    .ttd-wrap { margin-top:28px; display:table; width:100%; }
    .ttd-cell { display:table-cell; width:50%; vertical-align:top; }
    .ttd-right { text-align:right; }
    .ttd-label { font-size:10px; color:#374151; }
    .ttd-space { height:52px; border-bottom:1px solid #374151; width:150px; display:inline-block; margin:8px 0; }
    .ttd-nama  { font-size:10px; font-weight:bold; color:#111827; }
    .ttd-jabatan { font-size:9px; color:#6b7280; }

    .footer { margin-top:16px; padding-top:10px; border-top:1px solid #f3f4f6; font-size:9px; color:#9ca3af; display:flex; justify-content:space-between; }
</style>
</head>
<body>
<div class="page">

    {{-- Kop --}}
    <div class="kop">
        <div class="kop-logo">
            <img src="{{ public_path('images/logoSMK.png') }}">
        </div>
        <div class="kop-text">
            <div class="kop-sekolah">SMK MUHAMMADIYAH 3 KADUNGORA</div>
            <div class="kop-alamat">
                Jl. Raya Kadungora, Kadungora, Garut, Jawa Barat<br>
                Telp. (0262) 000000 | Email: smkm3kadungora@gmail.com
            </div>
        </div>
        <div class="kop-right">
            <span class="kop-badge">{{ strtoupper($tipe) }}</span>
            <div class="kop-date">{{ now()->format('d M Y') }}</div>
        </div>
    </div>

    {{-- Info surat --}}
    <div class="surat-info">
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td class="colon">:</td>
                <td>{{ now()->format('Y') }}/REKAP-BLY/{{ now()->format('m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Perihal</td>
                <td class="colon">:</td>
                <td>Rekapitulasi Laporan Bullying {{ $periodeLabel }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td class="colon">:</td>
                <td>{{ now()->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    {{-- Judul --}}
    <div class="judul-doc">
        <div class="judul-main">REKAPITULASI LAPORAN BULLYING</div>
        <div class="judul-sub">{{ $periodeLabel }}</div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-cell">
            <div class="stat-box sb-blue">
                <span class="stat-val">{{ $stats['totalLaporan'] }}</span>
                <span class="stat-lbl">Total Laporan</span>
            </div>
        </div>
        <div class="stat-cell">
            <div class="stat-box sb-green">
                <span class="stat-val">{{ $stats['selesai'] }}</span>
                <span class="stat-lbl">Diselesaikan</span>
            </div>
        </div>
        <div class="stat-cell">
            <div class="stat-box sb-red">
                <span class="stat-val">{{ $stats['ditolak'] }}</span>
                <span class="stat-lbl">Ditolak</span>
            </div>
        </div>
        <div class="stat-cell">
            <div class="stat-box sb-amber">
                <span class="stat-val">{{ $stats['rataRata'] }}</span>
                <span class="stat-lbl">Rata-rata/Hari</span>
            </div>
        </div>
    </div>

    {{-- Progress --}}
    @php
        $pct      = $stats['tingkatPenyelesaian'];
        $pctColor = $pct >= 75 ? '#10b981' : ($pct >= 50 ? '#f59e0b' : '#ef4444');
    @endphp
    <div class="progress-wrap">
        <div class="progress-label">
            <span>Tingkat Penyelesaian Keseluruhan</span>
            <span>{{ $pct }}%</span>
        </div>
        <div class="progress-track">
            <div class="progress-bar" style="@php echo 'width:' . min(100,$pct) . '%; background:' . $pctColor . ';'; @endphp"></div>
        </div>
    </div>

    {{-- Tabel per kelas --}}
    <div class="section-title" style="margin-top:4px">Detail Per Kelas</div>
    @if(count($tabel) > 0)
    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Total</th>
                <th>Selesai</th>
                <th>Ditolak</th>
                <th>Tingkat Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tabel as $i => $row)
            @php
                $p  = $row['total'] > 0 ? round(($row['selesai'] / $row['total']) * 100) : 0;
                $pc = $p >= 75 ? '#10b981' : ($p >= 50 ? '#f59e0b' : '#ef4444');
                $bc = $p >= 75 ? 'bp-good' : ($p >= 50 ? 'bp-mid' : 'bp-low');
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $row['kelas'] }}</strong></td>
                <td>{{ $row['total'] }}</td>
                <td>{{ $row['selesai'] }}</td>
                <td>{{ $row['ditolak'] ?? ($row['total'] - $row['selesai']) }}</td>
                <td>
                    <div class="bar-wrap">
                        <div class="bar-track">
                            <div class="bar-fill" style="@php echo 'width:' . $p . '%; background:' . $pc . ';'; @endphp"></div>
                        </div>
                    </div>
                    <span class="badge-pill {{ $bc }}" style="margin-left:6px">{{ $p }}%</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align:center; padding:20px; color:#9ca3af; border:1.5px dashed #e5e7eb; border-radius:8px;">
        Tidak ada data pada periode ini.
    </div>
    @endif

    {{-- TTD --}}
    <div class="ttd-wrap">
        <div class="ttd-cell">
            <div class="ttd-label">Mengetahui,</div>
            <div class="ttd-label">Kepala Sekolah</div>
            <div class="ttd-space"></div><br>
            <div class="ttd-nama">(__________________________)</div>
            <div class="ttd-jabatan">NIP. .................................</div>
        </div>
        <div class="ttd-cell ttd-right">
            <div class="ttd-label">Garut, {{ now()->format('d F Y') }}</div>
            <div class="ttd-label">Petugas BK / Kesiswaan</div>
            <div class="ttd-space"></div><br>
            <div class="ttd-nama">(__________________________)</div>
            <div class="ttd-jabatan">NIP. .................................</div>
        </div>
    </div>

    <div class="footer">
        <span>SIP Bullying — SMK Muhammadiyah 3 Kadungora</span>
        <span>Dicetak otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}</span>
    </div>

</div>
</body>
</html>