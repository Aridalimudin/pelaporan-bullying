<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1f2937; background: #fff; }

    .page { padding: 32px 36px; }

    /* Header */
    .header { border-bottom: 2.5px solid #10b981; padding-bottom: 14px; margin-bottom: 20px; }
    .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .school-name { font-size: 15px; font-weight: bold; color: #111827; }
    .school-sub  { font-size: 10px; color: #6b7280; margin-top: 2px; }
    .doc-label   { text-align: right; }
    .doc-label .badge {
        background: #10b981; color: #fff;
        font-size: 9px; font-weight: bold;
        padding: 3px 10px; border-radius: 99px;
        display: inline-block;
    }
    .doc-label .doc-date { font-size: 9px; color: #9ca3af; margin-top: 4px; }

    /* Title */
    .title-wrap { margin-bottom: 18px; }
    .title-main { font-size: 14px; font-weight: bold; color: #111827; }
    .title-sub  { font-size: 10px; color: #6b7280; margin-top: 3px; }

    /* Stats grid */
    .stats-grid { display: table; width: 100%; margin-bottom: 18px; border-spacing: 8px 0; }
    .stat-cell  { display: table-cell; width: 33%; }
    .stat-box   {
        border-radius: 8px; padding: 12px 10px; text-align: center;
        border: 1.5px solid;
    }
    .stat-val { font-size: 22px; font-weight: bold; display: block; line-height: 1; }
    .stat-lbl { font-size: 9px; font-weight: bold; display: block; margin-top: 3px; opacity: .8; }
    .sb-blue  { background: #eff6ff; border-color: #bfdbfe; color: #3b82f6; }
    .sb-green { background: #ecfdf5; border-color: #a7f3d0; color: #10b981; }
    .sb-red   { background: #fef2f2; border-color: #fecaca; color: #ef4444; }

    /* Progress */
    .progress-wrap { margin-bottom: 18px; }
    .progress-label { display: flex; justify-content: space-between; font-size: 10px; font-weight: bold; color: #6b7280; margin-bottom: 5px; }
    .progress-track { background: #f3f4f6; border-radius: 99px; height: 10px; }
    .progress-bar   { height: 10px; border-radius: 99px; }

    /* Urgensi */
    .section-title { font-size: 10px; font-weight: bold; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 10px; }
    .urg-grid { display: table; width: 100%; margin-bottom: 18px; border-spacing: 8px 0; }
    .urg-cell { display: table-cell; width: 33%; }
    .urg-box  { border-radius: 8px; padding: 10px; text-align: center; border: 1.5px solid; }
    .urg-val  { font-size: 18px; font-weight: bold; display: block; line-height: 1; }
    .urg-lbl  { font-size: 9px; font-weight: bold; display: block; margin-top: 3px; opacity: .8; }
    .ub-red   { background: #fef2f2; border-color: #fecaca; color: #ef4444; }
    .ub-amber { background: #fffbeb; border-color: #fde68a; color: #d97706; }
    .ub-green { background: #ecfdf5; border-color: #a7f3d0; color: #10b981; }

    /* Bar urgensi */
    .urg-bar-row { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 10px; }
    .urg-bar-lbl   { width: 48px; color: #6b7280; font-weight: bold; }
    .urg-bar-track { flex: 1; background: #f3f4f6; border-radius: 99px; height: 8px; }
    .urg-bar-fill  { height: 8px; border-radius: 99px; }
    .urg-bar-count { width: 20px; text-align: right; font-weight: bold; color: #374151; }

    /* Tabel laporan */
    .table-wrap { margin-top: 4px; }
    table { width: 100%; border-collapse: collapse; font-size: 10px; }
    thead th {
        background: #f9fafb; padding: 8px 10px;
        text-align: left; font-weight: bold; color: #6b7280;
        border-bottom: 1.5px solid #e5e7eb;
        border-top: 1.5px solid #e5e7eb;
    }
    tbody td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; color: #374151; }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:nth-child(even) td { background: #fafafa; }

    .badge-pill {
        display: inline-block; padding: 2px 7px; border-radius: 99px;
        font-size: 9px; font-weight: bold;
    }
    .bp-selesai { background:#ecfdf5; color:#10b981; }
    .bp-ditolak { background:#fef2f2; color:#ef4444; }
    .bp-tinggi  { background:#fef2f2; color:#ef4444; }
    .bp-sedang  { background:#fffbeb; color:#d97706; }
    .bp-rendah  { background:#ecfdf5; color:#10b981; }

    /* Placeholder kategori */
    .kategori-placeholder {
        border: 1.5px dashed #e5e7eb; border-radius: 8px;
        padding: 16px; text-align: center; color: #9ca3af;
        font-size: 10px; margin-top: 18px;
    }

    /* Footer */
    .footer {
        margin-top: 24px; padding-top: 12px;
        border-top: 1px solid #f3f4f6;
        display: flex; justify-content: space-between;
        font-size: 9px; color: #9ca3af;
    }
    /* Kop surat */
    .kop { display: table; width: 100%; border-bottom: 3px double #10b981; padding-bottom: 12px; margin-bottom: 18px; }
    .kop-logo { display: table-cell; width: 70px; vertical-align: middle; }
    .kop-logo img { width: 60px; height: 60px; }
    .kop-text { display: table-cell; vertical-align: middle; text-align: center; padding: 0 8px; }
    .kop-sekolah { font-size: 16px; font-weight: bold; color: #111827; line-height: 1.2; }
    .kop-alamat  { font-size: 9px; color: #6b7280; margin-top: 3px; line-height: 1.4; }
    .kop-right { display: table-cell; width: 70px; vertical-align: middle; text-align: right; }
    .kop-badge { background: #10b981; color: #fff; font-size: 8px; font-weight: bold; padding: 3px 8px; border-radius: 4px; display: inline-block; }
    .kop-date  { font-size: 8px; color: #9ca3af; margin-top: 4px; }

    /* Nomor surat */
    .surat-info { margin-bottom: 16px; font-size: 10px; color: #374151; }
    .surat-info table { width: auto; border-collapse: collapse; }
    .surat-info td { padding: 2px 8px 2px 0; vertical-align: top; }
    .surat-info .label { color: #6b7280; width: 110px; }
    .surat-info .colon { width: 10px; }

    /* Garis pemisah judul */
    .judul-doc {
        text-align: center; margin-bottom: 16px;
        padding: 10px; background: #f0fdf4;
        border-radius: 6px; border: 1px solid #d1fae5;
    }
    .judul-doc .judul-main { font-size: 13px; font-weight: bold; color: #065f46; }
    .judul-doc .judul-sub  { font-size: 10px; color: #10b981; margin-top: 3px; }

    /* Tanda tangan */
    .ttd-wrap { margin-top: 28px; display: table; width: 100%; }
    .ttd-cell { display: table-cell; width: 50%; vertical-align: top; }
    .ttd-right { text-align: right; }
    .ttd-label { font-size: 10px; color: #374151; }
    .ttd-space { height: 52px; border-bottom: 1px solid #374151; width: 150px; display: inline-block; margin: 8px 0; }
    .ttd-nama  { font-size: 10px; font-weight: bold; color: #111827; }
    .ttd-jabatan { font-size: 9px; color: #6b7280; }
</style>
</head>
<body>
<div class="page">

    {{-- Kop Surat --}}
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
            <span class="kop-badge">REKAP KELAS</span>
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
                <td>Rekapitulasi Laporan Bullying Kelas {{ $kelas }}</td>
            </tr>
            <tr>
                <td class="label">Periode</td>
                <td class="colon">:</td>
                <td>{{ $periodeLabel }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td class="colon">:</td>
                <td>{{ now()->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    {{-- Judul dokumen --}}
    <div class="judul-doc">
        <div class="judul-main">REKAPITULASI LAPORAN BULLYING</div>
        <div class="judul-sub">Kelas {{ $kelas }} &mdash; {{ $periodeLabel }}</div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-cell">
            <div class="stat-box sb-blue">
                <span class="stat-val">{{ $stats['total'] }}</span>
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
    </div>

    {{-- Progress --}}
    @php
        $pct      = $stats['pct'];
        $pctColor = $pct >= 75 ? '#10b981' : ($pct >= 50 ? '#f59e0b' : '#ef4444');
        $pctWidth = min(100, max(0, $pct));
    @endphp
    <div class="progress-wrap">
        <div class="progress-label">
            <span>Tingkat Penyelesaian</span>
            <span>{{ $pct }}%</span>
        </div>
        <div class="progress-track">
            <div class="progress-bar" style="@php echo 'width:' . $pctWidth . '%; background:' . $pctColor . ';'; @endphp"></div>
        </div>
    </div>

    {{-- Urgensi --}}
    <div class="section-title">Distribusi Urgensi</div>
    <div class="urg-grid">
        <div class="urg-cell">
            <div class="urg-box ub-red">
                <span class="urg-val">{{ $urgensi['tinggi'] }}</span>
                <span class="urg-lbl">Tinggi</span>
            </div>
        </div>
        <div class="urg-cell">
            <div class="urg-box ub-amber">
                <span class="urg-val">{{ $urgensi['sedang'] }}</span>
                <span class="urg-lbl">Sedang</span>
            </div>
        </div>
        <div class="urg-cell">
            <div class="urg-box ub-green">
                <span class="urg-val">{{ $urgensi['rendah'] }}</span>
                <span class="urg-lbl">Rendah</span>
            </div>
        </div>
    </div>

    {{-- Bar urgensi --}}
    @php $maxUrg = max($urgensi['tinggi'], $urgensi['sedang'], $urgensi['rendah'], 1); @endphp
    @foreach([['tinggi','#ef4444'],['sedang','#f59e0b'],['rendah','#10b981']] as [$key, $color])
    @php $w = round(($urgensi[$key] / $maxUrg) * 100); @endphp
    <div class="urg-bar-row">
        <span class="urg-bar-lbl">{{ ucfirst($key) }}</span>
        <div class="urg-bar-track">
            <div class="urg-bar-fill" style="@php echo 'width:' . $w . '%; background:' . $color . ';'; @endphp"></div>
        </div>
        <span class="urg-bar-count">{{ $urgensi[$key] }}</span>
    </div>
    @endforeach

    {{-- Tabel laporan --}}
    <div class="table-wrap" style="margin-top:18px">
        <div class="section-title">Riwayat Laporan Selesai & Ditolak</div>
        @if(count($laporan) > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Tiket</th>
                    <th>Pelapor</th>
                    <th>Urgensi</th>
                    <th>Status</th>
                    <th>Tgl Laporan</th>
                    <th>Tgl Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-family:monospace; color:#6b7280">{{ $r['ticket_code'] }}</td>
                    <td>{{ $r['student_name'] ?? '—' }}</td>
                    <td>
                        <span class="badge-pill bp-{{ $r['urgency'] }}">
                            {{ $r['urgency'] === 'tinggi' ? 'Tinggi' : ($r['urgency'] === 'sedang' ? 'Sedang' : 'Rendah') }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-pill bp-{{ $r['status'] }}">
                            {{ $r['status'] === 'selesai' ? 'Selesai' : 'Ditolak' }}
                        </span>
                    </td>
                    <td>{{ $r['created_at'] }}</td>
                    <td>{{ $r['handled_at'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align:center; padding:20px; color:#9ca3af; font-size:10px; border:1.5px dashed #e5e7eb; border-radius:8px;">
            Belum ada laporan selesai atau ditolak pada periode ini.
        </div>
        @endif
    </div>

    {{-- Placeholder kategori --}}
    <div class="kategori-placeholder">
        Kategori bullying akan tersedia setelah algoritma klasifikasi diimplementasikan.
    </div>

    {{-- Tanda tangan --}}
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

    {{-- Footer --}}
    <div class="footer" style="margin-top:16px; padding-top:10px; border-top:1px solid #f3f4f6; display:flex; justify-content:space-between; font-size:9px; color:#9ca3af;">
        <span>SIP Bullying — SMK Muhammadiyah 3 Kadungora</span>
        <span>Dicetak otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}</span>
    </div>

</div>
</body>
</html>

