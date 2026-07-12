@extends('layouts.app')
@section('title', 'Browse Courts')
@section('page-title', 'Browse Courts')

@section('content')

    <!-- Filter Bar -->
    <form method="GET" action="{{ route('courts.index') }}">
        <div class="filter-bar">
            <div class="form-group">
                <label>Search</label>
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Court name or location...">
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location"
                       value="{{ request('location') }}"
                       placeholder="Block A, B, C...">
            </div>

            <div class="form-group" style="max-width:140px;">
                <label>Max Price (RM/hr)</label>
                <input type="number" name="max_price"
                       value="{{ request('max_price') }}"
                       placeholder="50" min="0" step="5">
            </div>

            <div class="form-group" style="max-width:140px;">
                <label>Sort By</label>
                <select name="sort">
                    <option value="name"          {{ request('sort') === 'name'          ? 'selected' : '' }}>Name</option>
                    <option value="price_per_hour" {{ request('sort') === 'price_per_hour'? 'selected' : '' }}>Price</option>
                </select>
            </div>

            <div style="padding-bottom:0;">
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request()->hasAny(['search','location','max_price']))
                    <a href="{{ route('courts.index') }}" class="btn btn-secondary" style="margin-left:6px;">Clear</a>
                @endif
            </div>
        </div>
    </form>

    <!-- Results count -->
    @if(request()->hasAny(['search','location','max_price']))
        <p style="font-size:13px;color:#666;margin-bottom:14px;">
            Found <strong>{{ $courts->total() }}</strong> court(s)
        </p>
    @endif

    <!-- Courts Grid -->
    @if($courts->isEmpty())
        <div class="card">
            <div class="card-body" style="text-align:center;padding:40px;color:#888;">
                <p style="font-size:2rem;">&#127968;</p>
                <p style="margin-top:10px;">No courts found. Try adjusting your filters.</p>
                <a href="{{ route('courts.index') }}" class="btn btn-primary btn-sm" style="margin-top:12px;">
                    View All Courts
                </a>
            </div>
        </div>
    @else
        <div class="court-grid">
            @foreach($courts as $court)
            <div class="court-card">
                <!-- Icon Banner -->
                <div class="court-banner">&#127992;</div>

                <div class="court-body">
                    <div class="court-name">{{ $court->name }}</div>
                    <div class="court-location">&#128205; {{ $court->location }}</div>

                    <div style="font-size:12px;color:#666;margin-bottom:6px;">
                        Surface: {{ ucfirst($court->surface_type) }}
                        &nbsp;&bull;&nbsp;
                        Players: {{ $court->capacity }}
                    </div>

                    @if($court->amenities)
                    <div class="tags">
                        @foreach(array_slice($court->amenities, 0, 4) as $amenity)
                            <span class="tag">{{ ucfirst(str_replace('_', ' ', $amenity)) }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;">
                        <span class="court-price">RM{{ number_format($court->price_per_hour, 2) }}<span style="font-size:12px;color:#888;font-weight:normal;">/hr</span></span>
                        <span class="badge badge-success">Available</span>
                    </div>

                    <div class="court-actions">
                        <a href="{{ route('courts.show', $court) }}" class="btn btn-outline btn-sm">Details</a>
                        @auth
                            <a href="{{ route('bookings.create', ['court_id' => $court->id]) }}"
                               class="btn btn-primary btn-sm">Book Now</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login to Book</a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($courts->hasPages())
            <div style="margin-top:20px;">
                {{ $courts->links() }}
            </div>
        @endif
    @endif

@endsection
