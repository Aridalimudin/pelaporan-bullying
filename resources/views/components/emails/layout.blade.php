<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP Bullying - SMK Muhammadiyah 3</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif;color:#111827;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:32px 16px;">
    <tr><td align="center">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

            {{-- HEADER --}}
            <tr>
                <td style="background:{{ $headerBg ?? 'linear-gradient(135deg,#10b981,#047857)' }};padding:32px 40px;text-align:center;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" style="padding-bottom:18px;">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="background:rgba(255,255,255,.2);border-radius:12px;width:42px;height:42px;text-align:center;vertical-align:middle;">
                                            <span style="font-size:20px;line-height:42px;">🛡️</span>
                                        </td>
                                        <td style="padding-left:10px;text-align:left;vertical-align:middle;">
                                            <span style="display:block;font-size:15px;font-weight:800;color:#fff;">SIP Bullying</span>
                                            <span style="display:block;font-size:11px;color:rgba(255,255,255,.75);margin-top:1px;">SMK Muhammadiyah 3</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding-bottom:12px;">
                                <span style="display:inline-block;width:64px;height:64px;background:rgba(255,255,255,.2);border-radius:50%;font-size:28px;line-height:64px;text-align:center;">
                                    {{ $headerIcon ?? '📧' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h1 style="font-size:22px;font-weight:800;color:#fff;margin:0 0 6px;line-height:1.2;">{{ $headerTitle ?? 'Notifikasi' }}</h1>
                                <p style="font-size:13px;color:rgba(255,255,255,.8);margin:0;line-height:1.5;">{{ $headerSubtitle ?? 'Sistem Informasi Pelaporan Bullying' }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- BODY --}}
            <tr>
                <td style="padding:32px 40px;">
                    {{ $slot }}
                </td>
            </tr>

            {{-- FOOTER --}}
            <tr>
                <td style="background:#f9fafb;border-top:1px solid #e5e7eb;padding:20px 40px;text-align:center;">
                    <p style="font-size:12px;color:#9ca3af;margin:0 0 4px;">Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.</p>
                    <p style="font-size:12px;color:#9ca3af;margin:0 0 8px;">© {{ date('Y') }} SIP Bullying — SMK Muhammadiyah 3. Seluruh hak dilindungi.</p>
                    <p style="font-size:11px;color:#d1d5db;margin:0;">Jika Anda menerima email ini karena kesalahan, abaikan saja.</p>
                </td>
            </tr>

        </table>
    </td></tr>
</table>
</body>
</html>