<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #FAF9F6; color: #2E2B28; margin: 0; padding: 24px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border: 1px solid #E5E3DE; border-radius: 8px; overflow: hidden; }
        .header { background-image: linear-gradient(135deg, #9B897A 0%, #C09C7A 55%, #C9A14A 100%); padding: 24px; }
        .header h1 { color: #2E2B28; margin: 0; font-size: 20px; }
        .body { padding: 24px; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #9B897A; font-weight: 600; margin-top: 16px; margin-bottom: 4px; }
        .value { font-size: 14px; color: #2E2B28; }
        .message-box { background: #FAF9F6; border-left: 3px solid #C09C7A; padding: 16px; margin-top: 16px; font-size: 14px; color: #4A4642; white-space: pre-line; }
        .footer { background: #2E2B28; color: #B1AFAA; padding: 16px 24px; text-align: center; font-size: 12px; }
        .footer a { color: #C9A14A; text-decoration: none; }
        .btn { display: inline-block; padding: 10px 20px; margin-top: 16px; background: #C09C7A; color: #2E2B28; font-weight: 600; font-size: 13px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Enquiry</h1>
        </div>
        <div class="body">
            <p style="margin: 0 0 16px; color: #4A4642; font-size: 14px;">
                A new enquiry has arrived on the Nanchong Group website.
            </p>

            <div class="label">Source</div>
            <div class="value">
                @switch($submission->source)
                    @case('bay') Longines Bay @break
                    @case('island') Longines Island @break
                    @case('partnership') Land Partnership @break
                    @default General Website
                @endswitch
            </div>

            <div class="label">Name</div>
            <div class="value">{{ $submission->name }}</div>

            <div class="label">Phone</div>
            <div class="value"><a href="tel:{{ $submission->phone }}" style="color: #C09C7A;">{{ $submission->phone }}</a></div>

            <div class="label">Email</div>
            <div class="value"><a href="mailto:{{ $submission->email }}" style="color: #C09C7A;">{{ $submission->email }}</a></div>

            <div class="label">Message</div>
            <div class="message-box">{{ $submission->message }}</div>

            <a href="{{ url('/admin/contact-submissions/' . $submission->id) }}" class="btn">
                View in admin
            </a>
        </div>
        <div class="footer">
            Nanchong Group · {{ now()->format('M j, Y \a\t g:ia') }}
        </div>
    </div>
</body>
</html>