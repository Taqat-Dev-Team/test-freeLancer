<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ ($locale ?? 'ar') == 'en' ? 'Reply from Taqat Support Team' : 'رد من فريق دعم طاقات' }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');

        body {
            font-family: 'Tajawal', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .header {
            background: #1279be;
            padding: 25px;
            text-align: center;
            color: #fff;
        }

        .header img {
            max-width: 140px;
            margin-bottom: 10px;
        }

        .content {
            padding: 25px;
            line-height: 1.7;
            text-align: {{ ($locale ?? 'ar') == 'en' ? 'left' : 'right' }};
            direction: {{ ($locale ?? 'ar') == 'en' ? 'ltr' : 'rtl' }};
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #777;
        }

        .reply-box {
            background-color: #f1f1f1;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 6px;
            color: #1279be;
            font-weight: bold;
            white-space: pre-line;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ url('logos/white.png') }}" alt="Taqat Logo">
    </div>
    <div class="content">
        @if(($locale ?? 'ar') == 'en')
            <p>Hello{{ $userName ? ' ' . $userName : '' }},</p>
            <p>Thank you for contacting Taqat. Our team has reviewed your inquiry and here is our response:</p>
        @else
            <p>مرحبًا{{ $userName ? ' ' . $userName : '' }},</p>
            <p>شكرًا لتواصلك مع طاقات. لقد قمنا بمراجعة رسالتك، وردنا هو:</p>
        @endif

        <div class="reply-box">
            {{ $replyText }}
        </div>

        @if(($locale ?? 'ar') == 'en')
            <p>We are always happy to support you. If you have further questions, feel free to contact us again.</p>
            <p>Best regards,<br>Taqat Support Team</p>
        @else
            <p>نحن دائمًا سعداء بدعمك. إذا كانت لديك أي استفسارات إضافية، لا تتردد في التواصل معنا.</p>
            <p>مع أطيب التحيات،<br>فريق دعم طاقات</p>
        @endif
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ ($locale ?? 'ar') == 'en' ? 'Taqat. All rights reserved.' : 'طاقات. جميع الحقوق محفوظة.' }}</p>
    </div>
</div>
</body>
</html>
