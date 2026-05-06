<x-emails.layout
    headerBg="linear-gradient(135deg,#f97316,#c2410c)"
    headerIcon="⏰"
    headerTitle="Jangan Lupa Lengkapi Laporan Anda!"
    headerSubtitle="Detail tambahan diperlukan agar laporan dapat segera diproses">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? 'Pelapor') }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Kami mengingatkan bahwa laporan Anda dengan kode <strong style="font-family:'Courier New',monospace;color:#c2410c;">{{ $report->ticket_code }}</strong> telah diterima, namun <strong style="color:#c2410c;">detail tambahan belum dilengkapi</strong>. Tim pengelola tidak dapat memproses laporan ini lebih lanjut tanpa informasi tersebut.
    </p>

    {{-- Peringatan dari admin --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:14px;font-weight:700;color:#c2410c;margin:0 0 6px;">🔔 Pengingat dari Tim Pengelola</p>
                <p style="font-size:13px;color:#9a3412;margin:0;line-height:1.6;">
                    Tim pengelola SMK Muhammadiyah 3 telah meninjau laporan Anda dan membutuhkan informasi tambahan untuk menindaklanjutinya. Mohon segera lengkapi detail laporan agar proses penanganan dapat dimulai.
                </p>
            </td>
        </tr>
    </table>

    {{-- Kode Tiket --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4;border:1.5px solid #a7f3d0;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:14px 20px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#059669;margin:0 0 4px;">Kode Tiket Anda</p>
                <p style="font-family:'Courier New',monospace;font-size:22px;font-weight:800;color:#047857;margin:0;letter-spacing:.05em;">{{ $report->ticket_code }}</p>
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

    {{-- Tombol CTA --}}
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:8px 0 0;">
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#f97316,#c2410c);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;letter-spacing:.01em;">
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