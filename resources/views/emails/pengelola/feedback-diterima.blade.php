<x-emails.layout
    headerBg="linear-gradient(135deg,#f59e0b,#b45309)"
    headerIcon="⭐"
    headerTitle="Penilaian Diterima dari Pelapor"
    headerSubtitle="Pelapor telah memberikan feedback atas penanganan laporan">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $admin->nama ?? 'Pengelola' }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Pelapor untuk laporan <strong style="font-family:'Courier New',monospace;color:#b45309;">{{ $report->ticket_code }}</strong>
        telah memberikan penilaian atas penanganan yang dilakukan. Berikut ringkasannya.
    </p>

    {{-- Rating bintang --}}
    @php
        $rating   = $report->feedback->rating ?? 0;
        $pesan    = $report->feedback->pesan  ?? null;
        $emojiMap = ['', '😡', '😞', '😐', '😊', '🌟'];
        $labelMap = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Luar Biasa'];
        $colorMap = [
            '',
            ['bg'=>'#fef2f2','border'=>'#fca5a5','text'=>'#b91c1c'],
            ['bg'=>'#fef2f2','border'=>'#fca5a5','text'=>'#b91c1c'],
            ['bg'=>'#fffbeb','border'=>'#fde68a','text'=>'#92400e'],
            ['bg'=>'#f0fdf4','border'=>'#a7f3d0','text'=>'#065f46'],
            ['bg'=>'#f0fdf4','border'=>'#a7f3d0','text'=>'#065f46'],
        ];
        $c = $colorMap[$rating] ?? $colorMap[3];
    @endphp

    <table width="100%" cellpadding="0" cellspacing="0" style="background:{{ $c['bg'] }};border:1.5px solid {{ $c['border'] }};border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:20px 24px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:{{ $c['text'] }};margin:0 0 8px;">Penilaian Pelapor</p>
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-size:36px;line-height:1;padding-right:14px;vertical-align:middle;">
                            {{ $emojiMap[$rating] ?? '—' }}
                        </td>
                        <td style="vertical-align:middle;">
                            <p style="font-size:20px;font-weight:800;color:{{ $c['text'] }};margin:0;line-height:1.2;">
                                {{ $labelMap[$rating] ?? '—' }}
                            </p>
                            <p style="font-size:13px;color:{{ $c['text'] }};margin:4px 0 0;opacity:.8;">
                                Rating {{ $rating }}/5 bintang
                            </p>
                        </td>
                    </tr>
                </table>
                @if($pesan)
                <p style="font-size:13px;color:{{ $c['text'] }};margin:14px 0 0;padding:12px 14px;
                    background:rgba(255,255,255,.6);border-radius:8px;line-height:1.7;
                    font-style:italic;border-left:3px solid {{ $c['border'] }};">
                    "{{ $pesan }}"
                </p>
                @endif
            </td>
        </tr>
    </table>

    {{-- Info laporan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 20px;">
        <tr style="background:#f9fafb;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Informasi Laporan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:35%;">KODE TIKET</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-family:'Courier New',monospace;font-size:14px;font-weight:800;color:#b45309;">{{ $report->ticket_code }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">PELAPOR</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? '—') }}
                <span style="font-size:11px;background:{{ $report->reporter_type === 'ortu' ? '#f3e8ff' : '#dbeafe' }};color:{{ $report->reporter_type === 'ortu' ? '#7c3aed' : '#2563eb' }};padding:1px 7px;border-radius:99px;font-weight:600;margin-left:6px;">
                    {{ $report->reporter_type === 'ortu' ? 'Orang Tua' : 'Siswa' }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">STATUS LAPORAN</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;">
                @if($report->status === 'selesai')
                    <span style="background:#dcfce7;color:#166534;font-size:12px;font-weight:700;padding:3px 10px;border-radius:99px;">✅ Selesai Ditangani</span>
                @else
                    <span style="background:#fef2f2;color:#b91c1c;font-size:12px;font-weight:700;padding:3px 10px;border-radius:99px;">❌ Ditolak</span>
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;">TANGGAL FEEDBACK</td>
            <td style="padding:11px 16px;font-size:13px;color:#111827;">{{ now()->format('d F Y, H:i') }} WIB</td>
        </tr>
    </table>

    {{-- Kondisional: Selesai → tampilkan tindak lanjut | Ditolak → tampilkan alasan --}}
    @if($report->status === 'selesai' && $report->followUp)
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4;border:1.5px solid #a7f3d0;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#065f46;margin:0 0 10px;">✅ Tindakan yang Telah Diambil</p>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="font-size:12px;font-weight:600;color:#6b7280;width:40%;padding:4px 0;">JENIS TINDAKAN</td>
                        <td style="font-size:13px;color:#111827;font-weight:600;padding:4px 0;">{{ $report->followUp->jenis_tindakan }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:12px;font-weight:600;color:#6b7280;padding:4px 0;">TANGGAL PELAKSANAAN</td>
                        <td style="font-size:13px;color:#111827;padding:4px 0;">{{ $report->followUp->tanggal_pelaksanaan?->format('d F Y') }}</td>
                    </tr>
                    @if($report->followUp->pelaksana)
                    <tr>
                        <td style="font-size:12px;font-weight:600;color:#6b7280;padding:4px 0;">PELAKSANA</td>
                        <td style="font-size:13px;color:#111827;padding:4px 0;">{{ $report->followUp->pelaksana }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td style="font-size:12px;font-weight:600;color:#6b7280;padding:4px 0 0;vertical-align:top;">DESKRIPSI</td>
                        <td style="font-size:13px;color:#374151;line-height:1.6;padding:4px 0 0;">{{ Str::limit($report->followUp->deskripsi, 200) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @endif

    @if($report->status === 'ditolak')
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#b91c1c;margin:0 0 8px;">❌ Alasan Penolakan</p>
                <p style="font-size:13px;color:#7f1d1d;margin:0;line-height:1.7;font-style:italic;">
                    "{{ $report->rejection_reason ?? 'Tidak ada alasan yang tercatat.' }}"
                </p>
            </td>
        </tr>
    </table>
    @endif

    {{-- Tombol lihat detail --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url(($report->status === 'selesai' ? '/laporan-selesai' : '/laporan-ditolak') . '?open=' . $report->id) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#f59e0b,#b45309);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    📋 Lihat Detail Laporan
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>