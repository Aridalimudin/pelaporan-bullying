<x-emails.layout
    headerIcon="✅"
    headerTitle="Laporan Berhasil Dikirim"
    headerSubtitle="Terima kasih telah melaporkan kejadian bullying">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? 'Pelapor') }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Laporan Anda telah <strong style="color:#059669;">berhasil dikirim</strong> dan sedang menunggu ditinjau oleh tim pengelola. Kami akan segera menindaklanjuti laporan Anda.
    </p>

    {{-- Kode Tiket --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4;border:1.5px solid #a7f3d0;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#059669;margin:0 0 4px;">Kode Tiket Laporan</p>
                <p style="font-family:'Courier New',monospace;font-size:22px;font-weight:800;color:#047857;margin:0;letter-spacing:.05em;">{{ $report->ticket_code }}</p>
                <p style="font-size:12px;color:#6b7280;margin:4px 0 0;">Simpan kode ini untuk melacak status laporan Anda.</p>
            </td>
        </tr>
    </table>

    {{-- Info Laporan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 24px;">
        <tr style="background:#f9fafb;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Ringkasan Laporan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:40%;">TANGGAL KIRIM</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ $report->created_at->format('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">STATUS</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;">
                <span style="background:#dbeafe;color:#1d4ed8;font-size:12px;font-weight:700;padding:3px 10px;border-radius:99px;">Menunggu Tinjauan</span>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;">JENIS PELAPOR</td>
            <td style="padding:11px 16px;font-size:13px;color:#111827;">{{ $report->reporter_type === 'ortu' ? '👨‍👩‍👧 Orang Tua / Wali' : '👤 Siswa' }}</td>
        </tr>
    </table>

    {{-- Langkah selanjutnya --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#92400e;margin:0 0 8px;">📋 Langkah Selanjutnya</p>
                <p style="font-size:13px;color:#78350f;margin:0 0 6px;line-height:1.6;">1. Tim pengelola akan meninjau laporan Anda.</p>
                <p style="font-size:13px;color:#78350f;margin:0 0 6px;line-height:1.6;">2. Setelah diterima, Anda akan diminta mengisi detail tambahan.</p>
                <p style="font-size:13px;color:#78350f;margin:0;line-height:1.6;">3. Gunakan kode tiket di atas untuk memantau perkembangan laporan.</p>
            </td>
        </tr>
    </table>

    {{-- Tombol lacak --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:8px 0 0;">
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#10b981,#047857);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;letter-spacing:.01em;">
                    🔍 Lacak Status Laporan
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>