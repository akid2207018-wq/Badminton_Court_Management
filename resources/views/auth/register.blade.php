@extends('layouts.guest')
@section('title', 'Register')

@section('content')

<h2 style="font-size:1.1rem;margin-bottom:20px;color:#1e3a5f;text-align:center;">Create a New Account</h2>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name"
               value="{{ old('name') }}"
               placeholder="e.g. Ahmad Razif"
               class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
               required autofocus>
        @error('name')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}"
               placeholder="you@example.com"
               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
               required>
        @error('email')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="phone">Phone Number <span style="color:#888;font-weight:normal;">(optional)</span></label>
        <input type="text" id="phone" name="phone"
               value="{{ old('phone') }}"
               placeholder="e.g. 012-345 6789"
               class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
        @error('phone')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password"
               placeholder="Minimum 8 characters"
               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
               required>
        @error('password')
            <div class="error-msg">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               placeholder="Repeat your password"
               required>
    </div>

    <button type="submit" class="btn-submit">Create Account</button>
</form>

<div class="auth-footer">
    Already have an account? <a href="{{ route('login') }}">Login here</a>
</div>

@endsection
