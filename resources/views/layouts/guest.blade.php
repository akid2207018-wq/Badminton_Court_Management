<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome') — SmashCourt</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-box {
            background: #fff;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            width: 100%;
            max-width: 420px;
            padding: 36px 32px;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 6px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #1e3a5f;
        }

        .auth-logo span { color: #2c7be5; }

        .auth-tagline {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #444;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccd0d5;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background: #fff;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #2c7be5;
            box-shadow: 0 0 0 2px rgba(44,123,229,0.15);
        }

        input.is-invalid { border-color: #dc3545; }

        .form-group { margin-bottom: 16px; }

        .error-msg {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
        }

        .btn-submit {
            width: 100%;
            padding: 11px;
            background-color: #2c7be5;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 6px;
            transition: background-color 0.2s;
        }

        .btn-submit:hover { background-color: #1a68d1; }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }

        .auth-footer a { color: #2c7be5; }

        .alert {
            padding: 10px 14px;
            border-radius: 5px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            color: #555;
        }

        .checkbox-row input { width: auto; }

        hr { border: none; border-top: 1px solid #eee; margin: 16px 0; }
    </style>
</head>
<body>

<div class="auth-box">
    <div class="auth-logo">&#127992; Smash<span>Court</span></div>
    <div class="auth-tagline">Badminton Court Booking System</div>

    @if(session('success'))
        <div class="alert alert-success">&#10003; {{ session('success') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
