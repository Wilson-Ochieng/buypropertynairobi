<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #FAF9F6;
            color: #2E2B28;
            margin: 0;
            padding: 24px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #E5E3DE;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background-image: linear-gradient(135deg, #9B897A 0%, #C09C7A 55%, #C9A14A 100%);
            padding: 32px 24px;
            text-align: center;
        }

        .header h1 {
            color: #2E2B28;
            margin: 0;
            font-size: 22px;
        }

        .body {
            padding: 24px;
            font-size: 14px;
            color: #4A4642;
            line-height: 1.6;
        }

        .message-box {
            background: #FAF9F6;
            border-left: 3px solid #C09C7A;
            padding: 16px;
            margin: 16px 0;
            color: #2E2B28;
        }

        .footer {
            background: #2E2B28;
            color: #B1AFAA;
            padding: 16px 24px;
            text-align: center;
            font-size: 12px;
        }

        .footer a {
            color: #C9A14A;
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 16px;
            background: #C09C7A;
            color: #2E2B28;
            font-weight: 600;
            font-size: 13px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Thank you, {{ $submission->name }}!</h1>
        </div>
        <div class="body">
            <p>We've received your enquiry and our team will be in touch shortly.</p>

            <p><strong>What you sent us:</strong></p>
            <div class="message-box">{{ $submission->message }}</div>

            <p>If you'd like a faster reply, you can also reach us directly on WhatsApp:</p>
            <a href="https://wa.me/{{ preg_replace('/\D/', '', \App\Models\SiteContact::primary()?->phone ?? '254710998888') }}"
                class="btn">Chat on WhatsApp</a>

            <p style="margin-top: 24px; font-size: 13px; color: #9B897A;">
                Building homes for love, quality Nanchong.
            </p>
        </div>
        <div class="footer">
            Nanchong Group · <a href="{{ url('/') }}">Visit our website</a>
        </div>
    </div>
</body>

</html>