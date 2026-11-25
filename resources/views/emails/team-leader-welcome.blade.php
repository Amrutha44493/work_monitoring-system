<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Work Tracker</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont,
                'Segoe UI', sans-serif;
            background: #f1f5f9;
            padding: 40px 20px;
            color: #1e293b;
        }
        .wrapper {
            max-width: 520px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 24px;
        }
        .logo {
            display: inline-block;
            background: #f97316;
            width: 60px;
            height: 60px;
            border-radius: 16px;
            line-height: 60px;
            font-size: 28px;
            margin-bottom: 12px;
        }
        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        }
        .greeting {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .subtitle {
            color: #64748b;
            font-size: 14px;
            margin-bottom: 28px;
            line-height: 1.6;
        }
        .info-box {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .info-box p {
            font-size: 13px;
            color: #92400e;
            margin-bottom: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-box .value {
            font-size: 16px;
            color: #1e293b;
            font-weight: 700;
            font-family: monospace;
            text-transform: none;
            letter-spacing: 0;
        }
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 12px 0;
        }
        .btn {
            display: block;
            background: #f97316;
            color: #ffffff !important;
            text-align: center;
            padding: 14px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            margin-bottom: 20px;
        }
        .warning {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 14px;
            font-size: 12px;
            color: #991b1b;
            margin-bottom: 24px;
        }
        .features {
            margin-bottom: 24px;
        }
        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
        }
        .feature-icon {
            font-size: 18px;
            flex-shrink: 0;
        }
        .feature-text {
            font-size: 13px;
            color: #475569;
            line-height: 1.5;
        }
        .footer {
            text-align: center;
            margin-top: 24px;
            color: #94a3b8;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <div class="logo">🔧</div>
            <h1 style="font-size: 20px; font-weight: 700; color: #0f172a;">
                Kitchen Work Tracker
            </h1>
            <p style="color: #64748b; font-size: 13px; margin-top: 4px;">
                Work Monitoring System
            </p>
        </div>

        {{-- Card --}}
        <div class="card">

            <h2 class="greeting">
                Welcome, {{ $employee->name }}! 👋
            </h2>
            <p class="subtitle">
                Your Team Leader account has been created successfully.
                You can now log in to manage your team's work assignments
                and track productivity.
            </p>

            {{-- Login Credentials --}}
            <div class="info-box">
                <p>Your Login Details</p>
                <div class="divider"></div>

                <div style="margin-top: 12px;">
                    <p>Employee Code</p>
                    <div class="value">{{ $employee->employee_code }}</div>
                </div>

                <div class="divider"></div>

                <div>
                    <p>Email Address</p>
                    <div class="value">{{ $employee->email }}</div>
                </div>

                <div class="divider"></div>

                <div>
                    <p>Temporary Password</p>
                    <div class="value">{{ $password }}</div>
                </div>
            </div>

            {{-- Warning --}}
            <div class="warning">
                ⚠️ Please change your password after first login
                for security reasons.
            </div>

            {{-- CTA Button --}}
            <a href="{{ url('/login') }}" class="btn">
                Login to Dashboard →
            </a>

            {{-- Features --}}
            <div class="features">
                <p style="font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 12px;">
                    As Team Leader, you can:
                </p>
                <div class="feature-item">
                    <span class="feature-icon">👷</span>
                    <span class="feature-text">Manage your team members and track their performance</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">📋</span>
                    <span class="feature-text">Assign work tasks to employees with standard time targets</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">⏱️</span>
                    <span class="feature-text">Start and stop work timers to track actual time taken</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">📊</span>
                    <span class="feature-text">View detailed reports on productivity and performance</span>
                </div>
            </div>

            {{-- Support --}}
            <div style="background: #f8fafc; border-radius: 10px; padding: 14px; text-align: center;">
                <p style="font-size: 12px; color: #64748b;">
                    Need help? Contact your system administrator.
                </p>
            </div>

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>© {{ date('Y') }} Kitchen Work Tracker</p>
            <p style="margin-top: 4px;">
                This is an automated message. Please do not reply.
            </p>
        </div>

    </div>
</body>
</html>