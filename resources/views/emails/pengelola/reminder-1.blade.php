<x-emails.layout
    headerBg="linear-gradient(135deg,#f59e0b,#d97706)"
    headerIcon="🔔"
    headerTitle="Reminder Laporan #1"
    headerSubtitle="Pelapor mengingatkan untuk segera menindaklanjuti">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $admin->nama ?? 'Pengelola' }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Pelapor dari laporan <strong style="font-family:'Courier New',monospace;color:#d97706;">{{ $report->ticket_code }}</strong> telah mengirimkan <strong style="color:#d97706;">reminder pertama</strong>. Mereka meminta agar laporan segera ditindaklanjuti.
    </p>

    {{-- Info reminder --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#92400e;margin:0 0 6px;">🔔 Reminder ke-1 dari Pelapor</p>
                <p style="font-size:13px;color:#78350f;margin:0;line-height:1.6;">Pelapor masih menunggu tindak lanjut dari Anda. Mohon segera periksa laporan ini.</p>
            </td>
        </tr>
    </table>

    {{-- Detail laporan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 24px;">
        <tr style="background:#f9fafb;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Detail Laporan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:35%;">KODE TIKET</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-family:'Courier New',monospace;font-size:14px;font-weight:800;color:#d97706;">{{ $report->ticket_code }}</td>
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
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;">TOTAL REMINDER</td>
            <td style="padding:11px 16px;font-size:13px;font-weight:700;color:#d97706;">{{ $report->reminder_count }}x</td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/laporan-masuk?open=' . $report->id) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#f59e0b,#d97706);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    🔍 Tinjau Laporan
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>