<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>
        @if(($locale ?? 'ar') == 'en')
            Identity Verification Successful
        @else
            تم التحقق من الهوية بنجاح
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
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #1279be;
            padding: 30px 25px;
            text-align: center;
            color: #ffffff;
        }

        .header .logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }

        .content {
            padding: 30px 25px;
            line-height: 1.6;
            color: #555555;
        }

        .content p {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .success-box {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            color: #155724;
        }

        .footer {
            background-color: #f4f7f6;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            color: #777777;
            border-top: 1px solid #eeeeee;
        }

        .footer .logo-footer {
            max-width: 100px;
            height: auto;
            margin-top: 15px;
            opacity: 0.7;
        }

        .rtl {
            text-align: right;
            direction: rtl;
        }

        .ltr {
            text-align: left;
            direction: ltr;
        }
    </style>
</head>
<body>
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <table role="presentation" class="container">
                <tr>
                    <td class="header">
                        <img src="{{ url('logos/white.png') }}" alt="Taqat Logo" class="logo" />
                    </td>
                </tr>
                <tr>
                    <td class="content @if(($locale ?? 'ar') == 'en') ltr @else rtl @endif">
                        @if(($locale ?? 'ar') == 'en')
                            <p>Hello {{ $user->name }},</p>
                            <p>Congratulations! Your identity verification request has been <strong>approved successfully</strong>.</p>
                            <p>You can now fully enjoy the benefits and features of our platform.</p>
                        @else
                            <p>مرحبًا {{ $user->name }},</p>
                            <p>تهانينا! تم قبول طلب التحقق من هويتك <strong>بنجاح</strong>.</p>
                            <p>يمكنك الآن الاستفادة الكاملة من مزايا وخدمات المنصة.</p>
                        @endif

                        <div class="success-box">
                            @if(($locale ?? 'ar') == 'en')
                                Your account is now verified and active.
                            @else
                                حسابك الآن مفعل ومؤكد.
                            @endif
                        </div>

                        @if(($locale ?? 'ar') == 'en')
                            <p>If you have any questions or need assistance, please do not hesitate to contact our support team.</p>
                            <p>Thank you for being part of Taqat!</p>
                        @else
                            <p>إذا كان لديك أي استفسارات أو تحتاج إلى مساعدة، لا تتردد في التواصل مع فريق الدعم لدينا.</p>
                            <p>شكرًا لانضمامك إلى منصة طاقات!</p>
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
                        <img src="{{ asset('logos/logo.png') }}" alt="Taqat Logo" class="logo-footer" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
