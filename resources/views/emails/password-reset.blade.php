<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(($locale ?? 'ar') == 'en')
            Password Reset Request
        @else
            طلب إعادة تعيين كلمة المرور
        @endif
    </title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');
        body {
            font-family: 'Tajawal', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333333;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table { border-collapse: collapse; width: 100%; }
        td { padding: 0; }
        .container {
            width: 100%; max-width: 600px; margin: 0 auto;
            background-color: #ffffff; border-radius: 8px;
            overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #1279be; /* Primary Color */
            padding: 30px 25px; text-align: center; color: #ffffff;
        }
        .header h1 {
            font-family: 'Tajawal', sans-serif; margin: 0; font-size: 28px; font-weight: 700;
        }
        .header .logo { max-width: 150px; height: auto; margin-bottom: 15px; }
        .content {
            padding: 30px 25px; line-height: 1.6; color: #555555;
        }
        .content p { margin-bottom: 15px; font-size: 16px; }
        .button {
            display: inline-block; background-color: #1279be; color: #ffffff !important;
            padding: 12px 25px; border-radius: 5px; text-decoration: none;
            font-weight: bold; font-size: 16px; margin-top: 20px;
        }
        .footer {
            background-color: #f4f7f6; padding: 25px; text-align: center;
            font-size: 13px; color: #777777; border-top: 1px solid #eeeeee;
        }
        .footer p { margin: 5px 0; }
        .footer .logo-footer { max-width: 100px; height: auto; margin-top: 15px; opacity: 0.7; }
        .rtl { text-align: right; direction: rtl; }
        .ltr { text-align: left; direction: ltr; }
    </style>
</head>
<body>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="container">
                <tr>
                    <td class="header">
                        <img src="{{ url('logos/white.png') }}" alt="Taqat Logo" class="logo">
{{--                        <h1>طاقات / Taqat</h1>--}}
                    </td>
                </tr>
                <tr>
                    <td class="content @if(($locale ?? 'ar') == 'en') ltr @else rtl @endif">
                        @if(($locale ?? 'ar') == 'en')
                            <p>Hello,</p>
                            <p>You are receiving this email because we received a password reset request for your account.</p>
                            <p>To reset your password, click the button below:</p>
                            <p style="text-align: center;">
                                <a href="{{ $resetUrl }}" class="button" target="_blank" rel="noopener noreferrer">Reset Password</a>
                            </p>
                            <p>This password reset link will expire in {{ config('auth.passwords.users.expire') }} minutes.</p>
                            <p>If you did not request a password reset, no further action is required.</p>
                            <p>Regards,</p>
                            <p>The Taqat Team.</p>
                        @else
                            <p>مرحبًا،</p>
                            <p>تتلقى هذا البريد الإلكتروني لأننا تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك.</p>
                            <p>لإعادة تعيين كلمة المرور الخاصة بك، انقر على الزر أدناه:</p>
                            <p style="text-align: center;">
                                <a href="{{ $resetUrl }}" class="button" target="_blank" rel="noopener noreferrer">إعادة تعيين كلمة المرور</a>
                            </p>
                            <p>صلاحية رابط إعادة تعيين كلمة المرور هذا ستنتهي خلال {{ config('auth.passwords.users.expire') }} دقيقة.</p>
                            <p>إذا لم تطلب إعادة تعيين كلمة المرور، فلا داعي لاتخاذ أي إجراء آخر.</p>
                            <p>مع تحياتنا،</p>
                            <p>فريق طاقات.</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="footer @if(($locale ?? 'ar') == 'en') ltr @else rtl @endif">
                        <p>
                            @if(($locale ?? 'ar') == 'en')
                                &copy; {{ date('Y') }} Taqat. All rights reserved.
                            @else
                                &copy; {{ date('Y') }} طاقات. جميع الحقوق محفوظة.
                            @endif
                        </p>
                        <p>
{{--                            @if(($locale ?? 'ar') == 'en')--}}
{{--                                <a href="#" style="color: #1279be; text-decoration: none;">Privacy Policy</a>--}}
{{--                                &nbsp; | &nbsp;--}}
{{--                                <a href="#" style="color: #1279be; text-decoration: none;">Terms of Use</a>--}}
{{--                            @else--}}
{{--                                <a href="#" style="color: #1279be; text-decoration: none;">سياسة الخصوصية</a>--}}
{{--                                &nbsp; | &nbsp;--}}
{{--                                <a href="#" style="color: #1279be; text-decoration: none;">شروط الاستخدام</a>--}}
{{--                            @endif--}}
                        </p>
                        <img src="{{ asset('logos/logo.png') }}" alt="Taqat Logo" class="logo-footer">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
