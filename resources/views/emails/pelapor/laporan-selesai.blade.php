<x-emails.layout
    headerIcon="🎉"
    headerTitle="Laporan Selesai Ditangani!"
    headerSubtitle="Terima kasih atas kepercayaan Anda kepada kami">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $report->reporter_type === 'ortu' ? $report->reporter_name : ($report->student?->fullname ?? 'Pelapor') }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Kami dengan senang hati memberitahukan bahwa laporan <strong style="font-family:'Courier New',monospace;color:#047857;">{{ $report->ticket_code }}</strong> telah <strong style="color:#059669;">selesai ditangani</strong> oleh tim pengelola SMK Muhammadiyah 3.
    </p>

    {{-- Kode tiket --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4;border:1.5px solid #a7f3d0;border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:14px 20px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#059669;margin:0 0 4px;">Kode Tiket</p>
                <p style="font-family:'Courier New',monospace;font-size:20px;font-weight:800;color:#047857;margin:0;">{{ $report->ticket_code }}</p>
            </td>
        </tr>
    </table>

    {{-- Detail tindakan --}}
    @if($report->followUp)
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 20px;">
        <tr style="background:#f0fdf4;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #d1fae5;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#059669;margin:0;">✅ Tindakan yang Diambil</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:40%;">JENIS TINDAKAN</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;font-weight:600;color:#111827;">{{ $report->followUp->jenis_tindakan }}</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">TANGGAL TINDAKAN</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ $report->followUp->tanggal_pelaksanaan?->format('d F Y') }}
            </td>
        </tr>
        @if($report->followUp->pelaksana)
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">PELAKSANA</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ $report->followUp->pelaksana }}</td>
        </tr>
        @endif
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;vertical-align:top;">DESKRIPSI</td>
            <td style="padding:11px 16px;font-size:13px;color:#374151;line-height:1.6;">{{ $report->followUp->deskripsi }}</td>
        </tr>
    </table>
    @endif

    {{-- Minta feedback --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef9c3;border:1.5px solid #fde68a;border-radius:12px;margin:0 0 24px;">
        <tr>
            <td style="padding:16px 20px;">
                <p style="font-size:14px;font-weight:700;color:#92400e;margin:0 0 8px;">⭐ Bantu Kami Berkembang</p>
                <p style="font-size:13px;color:#78350f;margin:0 0 12px;line-height:1.6;">Pendapat Anda sangat berarti! Berikan penilaian atas penanganan laporan ini agar kami dapat terus meningkatkan layanan.</p>
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:#f59e0b;color:#ffffff;font-size:13px;font-weight:700;padding:10px 22px;border-radius:8px;text-decoration:none;">
                    ⭐ Berikan Penilaian
                </a>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/lacak?code=' . $report->ticket_code) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#10b981,#047857);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    🔍 Lihat Detail Laporan
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>