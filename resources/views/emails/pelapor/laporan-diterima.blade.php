<x-emails.layout
    headerIcon="📋"
    headerTitle="Laporan Diterima!"
    headerSubtitle="Segera lengkapi detail kejadian untuk mempercepat proses">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? 'Pelapor') }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Kabar baik! Laporan Anda dengan kode <strong style="color:#047857;font-family:'Courier New',monospace;">{{ $report->ticket_code }}</strong> telah <strong style="color:#059669;">diterima</strong> oleh tim pengelola. Untuk mempercepat proses penanganan, kami membutuhkan detail tambahan dari Anda.
    </p>

    {{-- Alert penting --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:14px;font-weight:700;color:#b91c1c;margin:0 0 6px;">⚠️ Tindakan Diperlukan</p>
                <p style="font-size:13px;color:#7f1d1d;margin:0;line-height:1.6;">Anda perlu mengisi detail tambahan seperti waktu kejadian, lokasi, dan pihak yang terlibat. Tanpa informasi ini, laporan tidak dapat diproses lebih lanjut.</p>
            </td>
        </tr>
    </table>

    {{-- Kode Tiket --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4;border:1.5px solid #a7f3d0;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:14px 20px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#059669;margin:0 0 4px;">Kode Tiket Anda</p>
                <p style="font-family:'Courier New',monospace;font-size:22px;font-weight:800;color:#047857;margin:0;">{{ $report->ticket_code }}</p>
            </td>
        </tr>
    </table>

    {{-- Detail yang harus diisi --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 24px;">
        <tr style="background:#f9fafb;">
            <td style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Detail yang Perlu Dilengkapi</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#374151;">
                📅 <strong>Tanggal & Waktu</strong> kejadian
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#374151;">
                📍 <strong>Lokasi</strong> kejadian
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#374151;">
                👤 <strong>Nama pelaku</strong> yang terlibat
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:13px;color:#374151;">
                👥 <strong>Nama korban & saksi</strong> (jika ada)
            </td>
        </tr>
    </table>

    {{-- Tombol --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:8px 0 0;">
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#10b981,#047857);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    📝 Lengkapi Detail Sekarang
                </a>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding-top:10px;">
                <p style="font-size:12px;color:#9ca3af;margin:0;">Atau buka halaman lacak laporan dan masukkan kode tiket Anda</p>
            </td>
        </tr>
    </table>

</x-emails.layout>