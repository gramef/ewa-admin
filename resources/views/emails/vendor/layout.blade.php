<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EWA Hair')</title>
    <style>
        /* Reset */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* Base styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f6f4;
            color: #2d2926;
            line-height: 1.6;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .email-header {
            background: linear-gradient(135deg, #c8956c 0%, #a67c52 100%);
            padding: 32px 40px;
            text-align: center;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            letter-spacing: 2px;
        }

        .email-header .tagline {
            color: rgba(255,255,255,0.85);
            font-size: 13px;
            margin-top: 6px;
            font-weight: 400;
        }

        .email-body {
            padding: 40px;
        }

        .email-body h2 {
            color: #2d2926;
            font-size: 22px;
            font-weight: 600;
            margin: 0 0 20px 0;
        }

        .email-body p {
            color: #4a4543;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 16px 0;
        }

        .email-body ul, .email-body ol {
            color: #4a4543;
            font-size: 15px;
            line-height: 1.8;
            padding-left: 24px;
            margin: 0 0 16px 0;
        }

        .email-body li {
            margin-bottom: 8px;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #c8956c 0%, #a67c52 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }

        .info-box {
            background: #faf7f4;
            border-left: 4px solid #c8956c;
            padding: 16px 20px;
            border-radius: 0 8px 8px 0;
            margin: 20px 0;
        }

        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #5a5552;
        }

        .email-footer {
            background: #f8f6f4;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .email-footer p {
            color: #999;
            font-size: 12px;
            margin: 0 0 4px 0;
        }

        .email-footer a {
            color: #c8956c;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8f6f4;padding:40px 20px;">
        <tr>
            <td align="center">
                <div class="email-wrapper">
                    <!-- Header -->
                    <div class="email-header">
                        <h1>EWA</h1>
                        <div class="tagline">Hair & Beauty Platform</div>
                    </div>

                    <!-- Body -->
                    <div class="email-body">
                        @yield('content')
                    </div>

                    <!-- Footer -->
                    <div class="email-footer">
                        <p>Need help? Contact us at <a href="mailto:support@ewaofficialapp.com">support@ewaofficialapp.com</a></p>
                        <p>&copy; {{ date('Y') }} EWA Hair. All rights reserved.</p>
                        <p><a href="https://ewaofficialapp.com">ewaofficialapp.com</a></p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
