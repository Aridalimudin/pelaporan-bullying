<x-emails.layout
    headerBg="linear-gradient(135deg,#7c3aed,#5b21b6)"
    headerIcon="📝"
    headerTitle="Detail Laporan Dilengkapi"
    headerSubtitle="Pelapor telah mengisi detail kejadian, segera beri tindakan">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $admin->nama ?? 'Pengelola' }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Pelapor telah melengkapi detail kejadian untuk laporan <strong style="font-family:'Courier New',monospace;color:#5b21b6;">{{ $report->ticket_code }}</strong>. Laporan ini kini siap untuk diverifikasi dan ditindaklanjuti.
    </p>

    {{-- Alert aksi --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f3ff;border:1.5px solid #c4b5fd;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:14px;font-weight:700;color:#5b21b6;margin:0 0 6px;">⚡ Tindakan Diperlukan</p>
                <p style="font-size:13px;color:#4c1d95;margin:0;line-height:1.6;">Laporan ini sudah memiliki detail lengkap dan menunggu verifikasi serta penentuan tindakan dari Anda.</p>
            </td>
        </tr>
    </table>

    {{-- Detail laporan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 20px;">
        <tr style="background:#f9fafb;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Ringkasan Laporan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:35%;">KODE TIKET</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-family:'Courier New',monospace;font-size:14px;font-weight:800;color:#5b21b6;">{{ $report->ticket_code }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">PELAPOR</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? '—') }}
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">WAKTU KEJADIAN</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ $report->incident_date?->format('d F Y') ?? '—' }}
                {{ $report->incident_time ? 'pukul ' . $report->incident_time : '' }}
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">LOKASI</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ $report->incident_location ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;vertical-align:top;">DESKRIPSI</td>
            <td style="padding:11px 16px;font-size:13px;color:#374151;line-height:1.6;">{{ Str::limit($report->deskripsi, 200) }}</td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/proses-laporan?open=' . $report->id) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#7c3aed,#5b21b6);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    ⚡ Beri Tindakan Sekarang
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>