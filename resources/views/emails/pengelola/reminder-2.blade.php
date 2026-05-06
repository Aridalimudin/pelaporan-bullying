<x-emails.layout
    headerBg="linear-gradient(135deg,#ef4444,#b91c1c)"
    headerIcon="🚨"
    headerTitle="Reminder Laporan #2 — SEGERA!"
    headerSubtitle="Pelapor sangat membutuhkan tindakan cepat dari Anda">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $admin->nama ?? 'Pengelola' }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Ini adalah <strong style="color:#dc2626;">reminder kedua</strong> dari pelapor untuk laporan <strong style="font-family:'Courier New',monospace;color:#b91c1c;">{{ $report->ticket_code }}</strong>. Pelapor sangat membutuhkan tindakan segera dari tim pengelola.
    </p>

    {{-- Alert mendesak --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1.5px solid #fca5a5;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:14px;font-weight:800;color:#b91c1c;margin:0 0 8px;">🚨 PERHATIAN — SEGERA DITINDAKLANJUTI</p>
                <p style="font-size:13px;color:#7f1d1d;margin:0;line-height:1.6;">Pelapor telah mengirim reminder sebanyak <strong>{{ $report->reminder_count }}x</strong>. Laporan ini membutuhkan perhatian dan tindakan <strong>sesegera mungkin</strong> untuk mencegah eskalasi masalah.</p>
            </td>
        </tr>
    </table>

    {{-- Detail laporan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #fca5a5;border-radius:12px;overflow:hidden;margin:0 0 20px;">
        <tr style="background:#fef2f2;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #fecaca;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#dc2626;margin:0;">Detail Laporan Mendesak</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:35%;">KODE TIKET</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-family:'Courier New',monospace;font-size:14px;font-weight:800;color:#b91c1c;">{{ $report->ticket_code }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">PELAPOR</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? '—') }}
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">STATUS SAAT INI</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ ucfirst($report->status) }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">MASUK SEJAK</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ $report->created_at->format('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;">TOTAL REMINDER</td>
            <td style="padding:11px 16px;">
                <span style="background:#fef2f2;color:#dc2626;font-size:13px;font-weight:800;padding:3px 10px;border-radius:99px;border:1px solid #fca5a5;">{{ $report->reminder_count }}x Reminder</span>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/laporan-masuk?open=' . $report->id) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#ef4444,#b91c1c);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    🚨 Tangani Sekarang
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>