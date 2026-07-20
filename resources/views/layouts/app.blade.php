<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SmashCourt') — Badminton Booking</title>

    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
            background-color: #f4f6f9;
            color: #333;
            min-height: 100vh;
        }

        a {
            color: #2c7be5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* ===== LAYOUT ===== */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 220px;
            background-color: #1e3a5f;
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 20px 18px;
            font-size: 1.2rem;
            font-weight: bold;
            border-bottom: 1px solid #2d5080;
            background-color: #163152;
        }

        .sidebar-brand span {
            color: #5bc0de;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 0;
        }

        .nav-label {
            padding: 10px 18px 4px;
            font-size: 11px;
            text-transform: uppercase;
            color: #7ea8cc;
            letter-spacing: 1px;
        }

        .sidebar-nav a {
            display: block;
            padding: 10px 18px;
            color: #bcd6f0;
            text-decoration: none;
            font-size: 14px;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: #2d5080;
            color: #fff;
            border-left-color: #5bc0de;
        }

        .sidebar-footer {
            padding: 14px 18px;
            border-top: 1px solid #2d5080;
        }

        .sidebar-footer form button {
            background: none;
            border: none;
            color: #bcd6f0;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
        }

        .sidebar-footer form button:hover {
            color: #ff7c7c;
        }

        /* ===== TOP BAR ===== */
        .topbar {
            background-color: #fff;
            border-bottom: 1px solid #dde3ea;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar .page-title {
            font-size: 1rem;
            font-weight: bold;
            color: #1e3a5f;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #555;
        }

        .topbar .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background-color: #2c7be5;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        /* ===== MAIN CONTENT ===== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        /* ===== ALERTS / MESSAGES ===== */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 6px 0 0 18px;
        }

        /* ===== CARDS ===== */
        .card {
            background-color: #fff;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 14px 18px;
            border-bottom: 1px solid #dde3ea;
            font-weight: bold;
            color: #1e3a5f;
            font-size: 14px;
            background-color: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 18px;
        }

        /* ===== STAT CARDS ===== */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2c7be5;
        }

        .stat-card .stat-label {
            font-size: 13px;
            color: #888;
            margin-top: 4px;
        }

        /* ===== TABLES ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table th {
            background-color: #f0f4f8;
            padding: 10px 14px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #555;
            border-bottom: 1px solid #dde3ea;
        }

        table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f0f2f5;
            color: #444;
        }

        table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* ===== FORMS ===== */
        .form-group {
            margin-bottom: 16px;
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
        input[type="password"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #ccd0d5;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            background: #fff;
            transition: border-color 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2c7be5;
            box-shadow: 0 0 0 2px rgba(44,123,229,0.15);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .error-msg {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
        }

        input.is-invalid,
        select.is-invalid,
        textarea.is-invalid {
            border-color: #dc3545;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-block;
            padding: 9px 18px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: #2c7be5;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #1a68d1;
            text-decoration: none;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
            color: #fff;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            color: #fff;
            text-decoration: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            color: #fff;
            text-decoration: none;
        }

        .btn-outline {
            background-color: #fff;
            color: #2c7be5;
            border: 1px solid #2c7be5;
        }

        .btn-outline:hover {
            background-color: #2c7be5;
            color: #fff;
            text-decoration: none;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 13px;
        }

        /* ===== BADGES ===== */
        .badge {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-success  { background-color: #d4edda; color: #155724; }
        .badge-warning  { background-color: #fff3cd; color: #856404; }
        .badge-danger   { background-color: #f8d7da; color: #721c24; }
        .badge-info     { background-color: #d1ecf1; color: #0c5460; }
        .badge-secondary{ background-color: #e2e3e5; color: #383d41; }
        .badge-primary  { background-color: #cce5ff; color: #004085; }

        /* ===== COURT CARDS ===== */
        .court-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .court-card {
            background: #fff;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            overflow: hidden;
        }

        .court-banner {
            height: 110px;
            background-color: #e8f0fb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .court-body {
            padding: 16px;
        }

        .court-name {
            font-size: 1rem;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 4px;
        }

        .court-location {
            font-size: 13px;
            color: #777;
            margin-bottom: 6px;
        }

        .court-price {
            font-size: 1.1rem;
            font-weight: bold;
            color: #28a745;
        }

        .court-actions {
            margin-top: 12px;
            display: flex;
            gap: 8px;
        }

        /* ===== AMENITY TAGS ===== */
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin: 8px 0;
        }

        .tag {
            background-color: #e8f0fb;
            color: #2c7be5;
            padding: 3px 9px;
            border-radius: 12px;
            font-size: 11px;
        }

        /* ===== SLOT GRID ===== */
        .slot-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 8px;
        }

        .slot-btn {
            padding: 10px 6px;
            border: 1px solid #ccd0d5;
            border-radius: 5px;
            background: #fff;
            font-size: 12px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }

        .slot-btn:hover:not(.booked) {
            border-color: #2c7be5;
            background-color: #e8f0fb;
            color: #2c7be5;
        }

        .slot-btn.selected {
            background-color: #2c7be5;
            color: #fff;
            border-color: #2c7be5;
        }

        .slot-btn.booked {
            background-color: #f0f2f5;
            color: #bbb;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        /* ===== SECTION HEADING ===== */
        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-heading h2 {
            font-size: 1.1rem;
            color: #1e3a5f;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            display: flex;
            gap: 4px;
            justify-content: center;
            padding: 16px 0 0;
            list-style: none;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 6px 12px;
            border: 1px solid #dde3ea;
            border-radius: 4px;
            font-size: 13px;
            color: #2c7be5;
            text-decoration: none;
        }

        .pagination .active span,
        .pagination span[aria-current="page"] span {
            background-color: #2c7be5;
            color: #fff;
            border-color: #2c7be5;
        }

        .pagination a:hover {
            background-color: #e8f0fb;
        }

        /* ===== PAYMENT METHODS ===== */
        .method-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 6px;
        }

        .method-option input[type="radio"] {
            display: none;
        }

        .method-option label {
            display: block;
            border: 2px solid #ccd0d5;
            border-radius: 6px;
            padding: 12px 8px;
            text-align: center;
            cursor: pointer;
            font-size: 12px;
            font-weight: normal;
        }

        .method-option label:hover {
            border-color: #2c7be5;
        }

        .method-option input[type="radio"]:checked + label {
            border-color: #2c7be5;
            background-color: #e8f0fb;
            color: #2c7be5;
            font-weight: bold;
        }

        .method-icon {
            display: block;
            font-size: 1.6rem;
            margin-bottom: 5px;
        }

        /* ===== INFO BOX ===== */
        .info-box {
            background-color: #e8f0fb;
            border: 1px solid #b8d4f0;
            border-radius: 6px;
            padding: 12px 16px;
            font-size: 13px;
            color: #1e3a5f;
        }

        .info-box.success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .info-box.warning {
            background-color: #fff3cd;
            border-color: #ffeaa0;
            color: #856404;
        }

        .info-box.danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* ===== PRICE SUMMARY BOX ===== */
        .summary-box {
            background-color: #f8f9fa;
            border: 1px solid #dde3ea;
            border-radius: 6px;
            padding: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 14px;
        }

        .summary-row.total {
            border-top: 1px solid #dde3ea;
            margin-top: 8px;
            padding-top: 12px;
            font-weight: bold;
            font-size: 1rem;
        }

        .summary-row .price {
            color: #28a745;
            font-weight: bold;
        }

        /* ===== FILTER BAR ===== */
        .filter-bar {
            background: #fff;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-bar .form-group {
            margin: 0;
            flex: 1;
            min-width: 140px;
        }

        .filter-bar label {
            font-size: 12px;
            margin-bottom: 4px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .stats-row { grid-template-columns: 1fr 1fr; }
            .court-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .slot-grid { grid-template-columns: repeat(2, 1fr); }
            .method-options { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
<div class="wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            &#127992; <span>SmashCourt</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                &#128202; Dashboard
            </a>

            <a href="{{ route('courts.index') }}"
               class="{{ request()->routeIs('courts.*') ? 'active' : '' }}">
                &#127968; Browse Courts
            </a>

            <div class="nav-label">Bookings</div>

            <a href="{{ route('bookings.create') }}"
               class="{{ request()->routeIs('bookings.create') ? 'active' : '' }}">
                &#43; Book a Court
            </a>

            <a href="{{ route('bookings.index') }}"
               class="{{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                &#128197; My Bookings
            </a>

            <a href="{{ route('payments.index') }}"
               class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">
                &#128179; Payments
            </a>

            <div class="nav-label">Account</div>

            <a href="{{ route('profile.edit') }}"
               class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                &#128100; My Profile
            </a>

            <div class="nav-label">Debug</div>

            <a href="{{ route('debug.cookies-sessions') }}"
               class="{{ request()->routeIs('debug.*') ? 'active' : '' }}">
                &#128274; Cookies &amp; Sessions
            </a>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">&#128682; Logout</button>
            </form>
        </div>
    </aside>

    <!-- Main Area -->
    <div class="main">

        <!-- Top Bar -->
        <div class="topbar">
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
                <span style="color:#bbb;">|</span>
                <a href="{{ route('profile.edit') }}" style="color:#2c7be5;font-size:13px;">Profile</a>
            </div>
        </div>

        <!-- Content -->
        <div class="content">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    &#10003; {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    &#9888; {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
