@extends('layouts.app')
@section('title', 'Cookies & Sessions')
@section('page-title', 'Cookies & Sessions Demo')

@section('content')

    <div class="stats-row" style="grid-template-columns: 1fr 1fr;">
        <div class="stat-card">
            <div class="stat-number">{{ $visitCount }}</div>
            <div class="stat-label">Page Visits (Session)</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color:#28a745;font-size:1.4rem;">{{ $lastCourt }}</div>
            <div class="stat-label">Last Viewed Court (Cookie - 7 days)</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">

        <div class="card">
            <div class="card-header">Session Data (stored in DB, lost when browser closes)</div>
            <div class="card-body">
                <div class="summary-row">
                    <span>visit_count</span>
                    <strong>{{ $visitCount }}</strong>
                </div>
                <div class="summary-row">
                    <span>last_visit</span>
                    <strong>{{ $lastVisit }}</strong>
                </div>
                <div style="margin-top:16px;">
                    <a href="{{ route('debug.session.reset') }}" class="btn btn-danger btn-sm"
                       onclick="event.preventDefault(); document.getElementById('reset-session-form').submit();">
                        Reset Session
                    </a>
                    <form id="reset-session-form" action="{{ route('debug.session.reset') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Cookie Data (stored in browser, lasts 7 days)</div>
            <div class="card-body">
                <div class="summary-row">
                    <span>last_court</span>
                    <strong>{{ $lastCourt }}</strong>
                </div>
                <div style="margin-top:16px;">
                    <a href="{{ route('debug.cookie.clear') }}" class="btn btn-danger btn-sm"
                       onclick="event.preventDefault(); document.getElementById('clear-cookie-form').submit();">
                        Clear Cookie
                    </a>
                    <form id="clear-cookie-form" action="{{ route('debug.cookie.clear') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection
