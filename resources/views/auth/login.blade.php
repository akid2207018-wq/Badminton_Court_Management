@extends('layouts.guest')
@section('title', 'Login')

@section('content')

<h2 style="font-size:1.1rem;margin-bottom:20px;color:#1e3a5f;text-align:center;">Sign In to Your Account</h2>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}"
               placeholder="you@example.com"
               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
               required autofocus>
        @error('email')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password"
               placeholder="Enter your password"
               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
               required>
        @error('password')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>

    <div class="checkbox-row">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember" style="font-weight:normal;margin:0;">Remember me</label>
    </div>

    <button type="submit" class="btn-submit">Login</button>
</form>

<div class="auth-footer">
    Don't have an account? <a href="{{ route('register') }}">Register here</a>
</div>

@endsection
