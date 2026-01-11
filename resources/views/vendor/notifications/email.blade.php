@php
    $colorPrimary = '#2563EB';
    $colorText = '#0F172A';
    $colorMuted = '#64748B';
    $colorBg = '#F8FAFC';
    $colorCard = '#FFFFFF';
    $colorBorder = '#E2E8F0';

    $appName = config('app.name');

    $levelMap = [
        'success' => '#16A34A',
        'error' => '#DC2626',
    ];

    $accent = $levelMap[$level ?? ''] ?? $colorPrimary;

    $safeGreeting = isset($greeting) ? $greeting : null;
@endphp

<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>{{ $appName }}</title>
</head>
<body style="margin:0; padding:0; background:{{ $colorBg }}; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; background:{{ $colorBg }};">
    <tr>
        <td align="center" style="padding:32px 12px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:600px; max-width:600px;">
                <tr>
                    <td align="center" style="padding:0 0 16px 0;">
                        <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            <tr>
                                <td style="vertical-align:middle; padding-right:10px;">
                                    <svg width="34" height="34" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                        <defs>
                                            <linearGradient id="gs_grad" x1="0" y1="0" x2="1" y2="1">
                                                <stop offset="0" stop-color="#2563EB"/>
                                                <stop offset="1" stop-color="#06B6D4"/>
                                            </linearGradient>
                                        </defs>
                                        <rect x="4" y="4" width="40" height="40" rx="12" fill="url(#gs_grad)"/>
                                        <path d="M16 25.5c0-5 4-9 9-9 3.4 0 6.4 1.8 8 4.6" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                                        <path d="M32 22.5v7.2c0 1.8-1.5 3.3-3.3 3.3H19.8" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                                        <path d="M19.5 33.2l-3.7 0" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                                    </svg>
                                </td>
                                <td style="vertical-align:middle;">
                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:18px; line-height:22px; color:{{ $colorText }}; font-weight:700;">
                                        {{ $appName }}
                                    </div>
                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:{{ $colorMuted }};">
                                        Stock management
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="background:{{ $colorCard }}; border:1px solid {{ $colorBorder }}; border-radius:16px; padding:28px 26px;">
                        @if (! empty($safeGreeting))
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:18px; line-height:26px; color:{{ $colorText }}; font-weight:700; margin:0 0 14px 0;">
                                {{ $safeGreeting }}
                            </div>
                        @endif

                        @foreach ($introLines as $line)
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:{{ $colorText }}; margin:0 0 10px 0;">
                                {{ $line }}
                            </div>
                        @endforeach

                        @isset($actionText)
                            <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin:18px 0 18px 0;">
                                <tr>
                                    <td align="center" bgcolor="{{ $accent }}" style="border-radius:12px;">
                                        <a href="{{ $actionUrl }}" style="display:inline-block; padding:12px 18px; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:18px; color:#ffffff; text-decoration:none; font-weight:700;">
                                            {{ $actionText }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        @endisset

                        @foreach ($outroLines as $line)
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:{{ $colorText }}; margin:0 0 10px 0;">
                                {{ $line }}
                            </div>
                        @endforeach

                        @if (! empty($salutation))
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:{{ $colorText }}; margin:18px 0 0 0;">
                                {{ $salutation }}
                            </div>
                        @else
                            <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:22px; color:{{ $colorText }}; margin:18px 0 0 0;">
                                Regards,<br>
                                {{ $appName }}
                            </div>
                        @endif

                        @isset($actionText)
                            <div style="margin-top:22px; padding-top:16px; border-top:1px solid {{ $colorBorder }};">
                                <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:{{ $colorMuted }}; margin:0 0 8px 0;">
                                    If you're having trouble clicking the button, copy and paste this URL into your browser:
                                </div>
                                <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:{{ $colorMuted }}; word-break:break-all;">
                                    <a href="{{ $actionUrl }}" style="color:{{ $colorPrimary }}; text-decoration:underline;">{{ $displayableActionUrl ?? $actionUrl }}</a>
                                </div>
                            </div>
                        @endisset
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:16px 8px 0 8px;">
                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:{{ $colorMuted }};">
                            © {{ date('Y') }} {{ $appName }}. All rights reserved.
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
