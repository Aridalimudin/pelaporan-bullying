<x-emails.layout
    headerBg="linear-gradient(135deg,#f59e0b,#d97706)"
    headerIcon="⏳"
    headerTitle="Laporan Sedang Diproses"
    headerSubtitle="Tim kami sedang menindaklanjuti laporan Anda">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? 'Pelapor') }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Detail laporan Anda telah kami terima. Laporan <strong style="font-family:'Courier New',monospace;color:#d97706;">{{ $report->ticket_code }}</strong> kini berstatus <strong style="color:#d97706;">Sedang Diproses</strong> oleh tim pengelola SMK Muhammadiyah 3.
    </p>

    {{-- Status progress --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fffbeb;border:1.5px solid #fde68a;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:13px;font-weight:700;color:#92400e;margin:0 0 12px;">📊 Progress Laporan</p>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align:center;width:25%;">
                            <span style="display:inline-block;width:28px;height:28px;background:#10b981;border-radius:50%;color:white;font-size:12px;font-weight:700;line-height:28px;text-align:center;">✓</span>
                            <p style="font-size:10px;color:#059669;font-weight:600;margin:4px 0 0;">Terkirim</p>
                        </td>
                        <td style="padding-bottom:14px;"><div style="height:2px;background:#10b981;"></div></td>
                        <td style="text-align:center;width:25%;">
                            <span style="display:inline-block;width:28px;height:28px;background:#10b981;border-radius:50%;color:white;font-size:12px;font-weight:700;line-height:28px;text-align:center;">✓</span>
                            <p style="font-size:10px;color:#059669;font-weight:600;margin:4px 0 0;">Diterima</p>
                        </td>
                        <td style="padding-bottom:14px;"><div style="height:2px;background:#f59e0b;"></div></td>
                        <td style="text-align:center;width:25%;">
                            <span style="display:inline-block;width:28px;height:28px;background:#f59e0b;border-radius:50%;color:white;font-size:12px;font-weight:700;line-height:28px;text-align:center;">⏳</span>
                            <p style="font-size:10px;color:#d97706;font-weight:700;margin:4px 0 0;">Diproses</p>
                        </td>
                        <td style="padding-bottom:14px;"><div style="height:2px;background:#e5e7eb;"></div></td>
                        <td style="text-align:center;width:25%;">
                            <span style="display:inline-block;width:28px;height:28px;background:#e5e7eb;border-radius:50%;color:#9ca3af;font-size:12px;font-weight:700;line-height:28px;text-align:center;">4</span>
                            <p style="font-size:10px;color:#9ca3af;margin:4px 0 0;">Selesai</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Info --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 24px;">
        <tr style="background:#f9fafb;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Info Laporan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:40%;">KODE TIKET</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-family:'Courier New',monospace;font-size:13px;font-weight:700;color:#047857;">{{ $report->ticket_code }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">DIPERBARUI</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ $report->updated_at->format('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;">STATUS</td>
            <td style="padding:11px 16px;">
                <span style="background:#fffbeb;color:#d97706;font-size:12px;font-weight:700;padding:3px 10px;border-radius:99px;border:1px solid #fde68a;">⏳ Sedang Diproses</span>
            </td>
        </tr>
    </table>

    <p style="font-size:13px;color:#6b7280;margin:0 0 20px;line-height:1.7;background:#f9fafb;padding:14px 16px;border-radius:10px;border-left:3px solid #f59e0b;">
        💡 Tim pengelola sedang mengkaji laporan dan menyiapkan tindakan yang sesuai. Mohon bersabar dan pantau perkembangan melalui tombol di bawah.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#f59e0b,#d97706);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    🔍 Pantau Perkembangan
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>