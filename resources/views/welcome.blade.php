<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmashCourt — Badminton Court Booking</title>
    <meta name="description" content="Book badminton courts online. Browse available courts, check time slots and reserve your spot instantly.">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            font-size: 15px;
            background-color: #f4f6f9;
            color: #333;
        }

        a { color: #2c7be5; text-decoration: none; }
        a:hover { text-decoration: underline; }

        /* ===== NAVBAR ===== */
        .navbar {
            background-color: #1e3a5f;
            color: #fff;
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .brand {
            font-size: 1.3rem;
            font-weight: bold;
            color: #fff;
        }

        .navbar .brand span { color: #5bc0de; }

        .navbar-links { display: flex; gap: 10px; align-items: center; }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .btn-white {
            background-color: #fff;
            color: #1e3a5f;
        }

        .btn-white:hover { background-color: #e8f0fb; text-decoration: none; }

        .btn-outline-white {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        .btn-outline-white:hover { background-color: rgba(255,255,255,0.1); text-decoration: none; }

        .btn-primary {
            background-color: #2c7be5;
            color: #fff;
        }

        .btn-primary:hover { background-color: #1a68d1; text-decoration: none; color: #fff; }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover { background-color: #218838; text-decoration: none; color: #fff; }

        /* ===== HERO ===== */
        .hero {
            background-color: #1e3a5f;
            color: #fff;
            text-align: center;
            padding: 60px 20px 50px;
        }

        .hero h1 {
            font-size: 2.2rem;
            margin-bottom: 12px;
        }

        .hero h1 span { color: #5bc0de; }

        .hero p {
            color: #9bbcd4;
            font-size: 1rem;
            max-width: 500px;
            margin: 0 auto 28px;
            line-height: 1.6;
        }

        .hero-search {
            display: flex;
            justify-content: center;
            gap: 0;
            max-width: 480px;
            margin: 0 auto 24px;
        }

        .hero-search input {
            flex: 1;
            padding: 11px 14px;
            border: none;
            border-radius: 5px 0 0 5px;
            font-size: 14px;
            outline: none;
        }

        .hero-search button {
            padding: 11px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
        }

        .hero-search button:hover { background-color: #218838; }

        .hero-buttons { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

        /* ===== STATS BAR ===== */
        .stats-bar {
            background-color: #163152;
            display: flex;
            justify-content: center;
            gap: 60px;
            padding: 18px 20px;
            flex-wrap: wrap;
        }

        .stats-bar .stat { text-align: center; color: #fff; }
        .stats-bar .stat .num { font-size: 1.6rem; font-weight: bold; color: #5bc0de; }
        .stats-bar .stat .lbl { font-size: 12px; color: #9bbcd4; margin-top: 2px; }

        /* ===== SECTIONS ===== */
        .section { padding: 50px 32px; max-width: 1100px; margin: 0 auto; }

        .section-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 6px;
        }

        .section-sub { color: #888; font-size: 14px; margin-bottom: 28px; }

        /* ===== COURTS GRID ===== */
        .courts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .court-card {
            background: #fff;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            overflow: hidden;
        }

        .court-banner {
            height: 100px;
            background-color: #e8f0fb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .court-body { padding: 14px; }

        .court-name { font-size: 15px; font-weight: bold; color: #1e3a5f; margin-bottom: 4px; }

        .court-location { font-size: 12px; color: #888; margin-bottom: 4px; }

        .court-meta { font-size: 12px; color: #666; margin-bottom: 10px; }

        .court-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .court-price { font-size: 1.1rem; font-weight: bold; color: #28a745; }

        /* ===== HOW IT WORKS ===== */
        .how-it-works { background-color: #fff; padding: 50px 32px; }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .step {
            text-align: center;
            padding: 24px 16px;
            border: 1px solid #dde3ea;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .step-icon { font-size: 2.2rem; margin-bottom: 10px; display: block; }

        .step h4 { font-size: 15px; color: #1e3a5f; margin-bottom: 6px; }

        .step p { font-size: 13px; color: #777; line-height: 1.5; }

        .step-num {
            display: inline-block;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: #2c7be5;
            color: #fff;
            font-weight: bold;
            font-size: 13px;
            line-height: 26px;
            text-align: center;
            margin-bottom: 10px;
        }

        /* ===== CTA ===== */
        .cta {
            background-color: #1e3a5f;
            color: #fff;
            text-align: center;
            padding: 50px 20px;
        }

        .cta h2 { font-size: 1.6rem; margin-bottom: 10px; }
        .cta p { color: #9bbcd4; margin-bottom: 24px; }

        /* ===== FOOTER ===== */
        footer {
            background-color: #163152;
            color: #9bbcd4;
            text-align: center;
            padding: 20px;
            font-size: 13px;
        }

        footer strong { color: #5bc0de; }

        /* ===== BADGES ===== */
        .badge-success {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: bold;
        }

        /* ===== TAGS ===== */
        .tag {
            background-color: #e8f0fb;
            color: #2c7be5;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            display: inline-block;
            margin: 2px 2px 0 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .courts-grid { grid-template-columns: 1fr; }
            .steps-grid  { grid-template-columns: 1fr 1fr; }
            .stats-bar   { gap: 30px; }
            .hero h1     { font-size: 1.6rem; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="brand">&#127992; Smash<span>Court</span></div>
    <div class="navbar-links">
        <a href="{{ route('courts.index') }}" class="btn btn-outline-white btn-sm"
           style="padding:6px 14px;font-size:13px;">Browse Courts</a>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-white" style="padding:6px 14px;font-size:13px;">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-white" style="padding:6px 14px;font-size:13px;">
                Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-white" style="padding:6px 14px;font-size:13px;">
                Register
            </a>
        @endauth
    </div>
</nav>

<!-- Hero -->
<section class="hero">
    <h1>Book Badminton Courts <span>Online</span></h1>
    <p>Browse available courts, pick your time slot and confirm your reservation in minutes.</p>

    <form action="{{ route('courts.index') }}" method="GET">
        <div class="hero-search">
            <input type="text" name="search" placeholder="Search by court name or location...">
            <button type="submit">Search</button>
        </div>
    </form>

    <div class="hero-buttons">
        <a href="{{ route('courts.index') }}" class="btn btn-success">Browse Courts</a>
        @guest
            <a href="{{ route('register') }}" class="btn btn-outline-white">Create Free Account</a>
        @endguest
    </div>
</section>

<!-- Stats Bar -->
<div class="stats-bar">
    <div class="stat">
        <div class="num">{{ \App\Models\Court::available()->count() }}</div>
        <div class="lbl">Courts Available</div>
    </div>
    <div class="stat">
        <div class="num">15</div>
        <div class="lbl">Time Slots / Day</div>
    </div>
    <div class="stat">
        <div class="num">{{ \App\Models\Booking::where('status', 'confirmed')->count() }}+</div>
        <div class="lbl">Bookings Made</div>
    </div>
    <div class="stat">
        <div class="num">7</div>
        <div class="lbl">Days a Week</div>
    </div>
</div>

<!-- Courts Section -->
<div class="section">
    <div class="section-title">Available Courts</div>
    <p class="section-sub">Choose from our well-maintained badminton courts</p>

    <div class="courts-grid">
        @foreach(\App\Models\Court::available()->take(6)->get() as $court)
        <div class="court-card">
            <div class="court-banner">&#127992;</div>
            <div class="court-body">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
                    <div class="court-name">{{ $court->name }}</div>
                    <span class="badge-success">Available</span>
                </div>
                <div class="court-location">&#128205; {{ $court->location }}</div>
                <div class="court-meta">
                    Surface: {{ ucfirst($court->surface_type) }}
                    &bull; {{ $court->capacity }} players
                </div>

                @if($court->amenities)
                <div style="margin-bottom:10px;">
                    @foreach(array_slice($court->amenities, 0, 3) as $amenity)
                        <span class="tag">{{ ucfirst(str_replace('_',' ',$amenity)) }}</span>
                    @endforeach
                </div>
                @endif

                <div class="court-footer">
                    <span class="court-price">RM{{ number_format($court->price_per_hour, 2) }}<span style="font-size:12px;color:#888;font-weight:normal;">/hr</span></span>
                    <a href="{{ route('courts.show', $court) }}" class="btn btn-primary" style="padding:6px 14px;font-size:13px;">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="text-align:center;">
        <a href="{{ route('courts.index') }}" class="btn btn-primary">View All Courts &rarr;</a>
    </div>
</div>

<!-- How It Works -->
<div class="how-it-works">
    <div style="text-align:center;max-width:1100px;margin:0 auto 28px;">
        <div class="section-title">How It Works</div>
        <p class="section-sub">Book your court in 4 simple steps</p>
    </div>
    <div class="steps-grid">
        <div class="step">
            <div class="step-num">1</div>
            <span class="step-icon">&#128100;</span>
            <h4>Register</h4>
            <p>Create a free account with your name and email.</p>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <span class="step-icon">&#127968;</span>
            <h4>Browse Courts</h4>
            <p>View available courts, prices, and amenities.</p>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <span class="step-icon">&#128197;</span>
            <h4>Pick a Slot</h4>
            <p>Choose your date and an available time slot.</p>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <span class="step-icon">&#128179;</span>
            <h4>Pay &amp; Confirm</h4>
            <p>Complete simulated payment to confirm your booking.</p>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="cta">
    <h2>Ready to Play?</h2>
    <p>Join now and book your first court in minutes. No waiting, no hassle.</p>
    @guest
        <a href="{{ route('register') }}" class="btn btn-success" style="margin-right:10px;">
            Create Free Account
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline-white">Login</a>
    @else
        <a href="{{ route('bookings.create') }}" class="btn btn-success">Book a Court Now</a>
    @endguest
</div>

<!-- Footer -->
<footer>
    <strong>SmashCourt</strong> &mdash; Badminton Court Booking System &copy; {{ date('Y') }}
</footer>

</body>
</html>
