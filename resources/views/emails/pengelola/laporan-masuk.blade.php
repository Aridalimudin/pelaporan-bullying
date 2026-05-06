<x-emails.layout
    headerBg="linear-gradient(135deg,#3b82f6,#1d4ed8)"
    headerIcon="📥"
    headerTitle="Laporan Baru Masuk"
    headerSubtitle="Segera tinjau dan tindaklanjuti laporan ini">

    <p style="font-size:15px;color:#374151;margin:0 0 16px;line-height:1.6;">
        Halo, <strong>{{ $admin->nama ?? 'Pengelola' }}</strong> 👋
    </p>
    <p style="font-size:14px;color:#6b7280;margin:0 0 20px;line-height:1.7;">
        Ada <strong style="color:#1d4ed8;">laporan baru</strong> yang masuk dan memerlukan perhatian Anda segera.
    </p>

    {{-- Urgensi badge --}}
    @php
        $urgMap = [
            'tinggi' => ['bg'=>'#fef2f2','color'=>'#dc2626','border'=>'#fca5a5','label'=>'🔴 TINGGI'],
            'sedang' => ['bg'=>'#fffbeb','color'=>'#d97706','border'=>'#fde68a','label'=>'🟡 SEDANG'],
            'rendah' => ['bg'=>'#f0fdf4','color'=>'#059669','border'=>'#a7f3d0','label'=>'🟢 RENDAH'],
        ];
        $urg = $urgMap[strtolower($report->urgency ?? 'sedang')] ?? $urgMap['sedang'];
    @endphp
    <table width="100%" cellpadding="0" cellspacing="0" style="background:{{ $urg['bg'] }};border:1.5px solid {{ $urg['border'] }};border-radius:12px;margin:0 0 20px;">
        <tr>
            <td style="padding:12px 20px;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:{{ $urg['color'] }};margin:0 0 3px;">Tingkat Urgensi</p>
                <p style="font-size:16px;font-weight:800;color:{{ $urg['color'] }};margin:0;">{{ $urg['label'] }}</p>
            </td>
        </tr>
    </table>

    {{-- Detail laporan --}}
    <table width="100%" cellpadding="0" cellspacing="0" style="border:1.5px solid #e5e7eb;border-radius:12px;overflow:hidden;margin:0 0 20px;">
        <tr style="background:#f9fafb;">
            <td colspan="2" style="padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#6b7280;margin:0;">Detail Laporan</p>
            </td>
        </tr>
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;width:35%;">KODE TIKET</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-family:'Courier New',monospace;font-size:14px;font-weight:800;color:#047857;">{{ $report->ticket_code }}</td>
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
        @if($report->reporter_type === 'ortu')
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">NAMA ANAK</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ explode(' | ', $report->catatan_admin ?? '')[0] ?? '—' }}
            </td>
        </tr>
        @else
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">KELAS</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">
                {{ $report->student ? $report->student->grade . ' ' . $report->student->major : '—' }}
            </td>
        </tr>
        @endif
        <tr>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:12px;font-weight:600;color:#9ca3af;">TANGGAL MASUK</td>
            <td style="padding:11px 16px;border-bottom:1px solid #f3f4f6;font-size:13px;color:#111827;">{{ $report->created_at->format('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="padding:11px 16px;font-size:12px;font-weight:600;color:#9ca3af;vertical-align:top;">DESKRIPSI</td>
            <td style="padding:11px 16px;font-size:13px;color:#374151;line-height:1.6;">
                {{ Str::limit($report->deskripsi, 200) }}
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <a href="{{ url('/laporan-masuk?open=' . $report->id) }}"
                   style="display:inline-block;background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:#ffffff;font-size:14px;font-weight:700;padding:13px 32px;border-radius:10px;text-decoration:none;">
                    👁️ Tinjau Laporan Sekarang
                </a>
            </td>
        </tr>
    </table>

</x-emails.layout>