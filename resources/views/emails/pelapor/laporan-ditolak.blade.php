<x-emails.layout
    headerBg="linear-gradient(135deg,#ef4444,#b91c1c)"
    headerIcon="❌"
    headerTitle="Laporan Tidak Dapat Diproses"
    headerSubtitle="Kami mohon maaf atas ketidaknyamanan ini">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? 'Pelapor') }}</strong>
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Kami mohon maaf, laporan dengan kode <strong style="font-family:'Courier New',monospace;color:#b91c1c;">{{ $report->ticket_code }}</strong> tidak dapat kami proses lebih lanjut. Berikut informasi lengkapnya.
    </p>

    {{-- Kode tiket --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:14px 20px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#dc2626;margin:0 0 4px;">Kode Tiket</p>
                <p style="font-family:'Courier New',monospace;font-size:20px;font-weight:800;color:#b91c1c;margin:0;">{{ $report->ticket_code }}</p>
            </td>
        </tr>
    </table>

    {{-- Alasan penolakan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #fca5a5;border-radius:12px;overflow:hidden;margin:0 0 20px;background:#fff;">
        <tr style="background:#fef2f2;">
            <td style="padding:12px 16px;border-bottom:1px solid #fecaca;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#dc2626;margin:0;">Alasan Penolakan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:16px;">
                <p style="font-size:14px;color:#7f1d1d;line-height:1.7;margin:0;font-style:italic;">
                    "{{ $report->rejection_reason ?? 'Tidak ada alasan yang diberikan.' }}"
                </p>
            </td>
        </tr>
    </table>

    {{-- Saran --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#92400e;margin:0 0 8px;">💡 Yang Dapat Anda Lakukan</p>
                <p style="font-size:13px;color:#78350f;margin:0 0 6px;line-height:1.6;">• Periksa kembali informasi yang Anda berikan.</p>
                <p style="font-size:13px;color:#78350f;margin:0 0 6px;line-height:1.6;">• Jika Anda yakin laporan ini valid, hubungi langsung pihak sekolah.</p>
                <p style="font-size:13px;color:#78350f;margin:0;line-height:1.6;">• Anda dapat membuat laporan baru dengan informasi yang lebih lengkap.</p>
            </td>
        </tr>
    </table>

    {{-- Minta feedback --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#374151;margin:0 0 8px;">⭐ Pendapat Anda Penting</p>
                <p style="font-size:13px;color:#6b7280;margin:0 0 12px;line-height:1.6;">Meskipun laporan ini tidak dapat diproses, penilaian Anda membantu kami memperbaiki layanan.</p>
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:#6b7280;color:#ffffff;font-size:13px;font-weight:700;padding:10px 22px;border-radius:8px;text-decoration:none;">
                    ⭐ Berikan Penilaian
                </a>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/lapor') }}"
                   style="display:inline-block;background:linear-gradient(135deg,#10b981,#047857);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    📝 Buat Laporan Baru
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>