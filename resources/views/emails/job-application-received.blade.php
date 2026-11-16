<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: -apple-system, sans-serif;
            background: #FAF9F6;
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
            background-image: linear-gradient(135deg, #9B897A, #C9A14A);
            padding: 24px;
        }

        .header h1 {
            color: #2E2B28;
            margin: 0;
            font-size: 20px;
        }

        .body {
            padding: 24px;
            font-size: 14px;
            color: #4A4642;
        }

        .label {
            font-size: 11px;
            text-transform: uppercase;
            color: #9B897A;
            font-weight: 600;
            margin-top: 16px;
        }

        .value {
            font-size: 14px;
            color: #2E2B28;
            margin-top: 4px;
        }

        .message {
            background: #FAF9F6;
            border-left: 3px solid #C09C7A;
            padding: 16px;
            margin-top: 16px;
            white-space: pre-line;
        }

        .footer {
            background: #2E2B28;
            color: #B1AFAA;
            padding: 16px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Job Application</h1>
        </div>
        <div class="body">
            <div class="label">Applied For</div>
            <div class="value">{{ $application->jobListing?->title ?? 'General Application' }}</div>

            <div class="label">Name</div>
            <div class="value">{{ $application->name }}</div>

            <div class="label">Email</div>
            <div class="value">{{ $application->email }}</div>

            <div class="label">Phone</div>
            <div class="value">{{ $application->phone }}</div>

            @if($application->current_location)
                <div class="label">Current Location</div>
                <div class="value">{{ $application->current_location }}</div>
            @endif

            @if($application->linkedin_url)
                <div class="label">LinkedIn</div>
                <div class="value"><a href="{{ $application->linkedin_url }}"
                        style="color: #C09C7A;">{{ $application->linkedin_url }}</a></div>
            @endif

            <div class="label">Cover Letter</div>
            <div class="message">{{ $application->cover_letter }}</div>

            @if($application->cv_path)
                <div class="label">CV</div>
                <div class="value">Attached to this email</div>
            @endif
        </div>
        <div class="footer">
            Nanchong Group · {{ now()->format('M j, Y \a\t g:ia') }}
        </div>
    </div>
</body>

</html>