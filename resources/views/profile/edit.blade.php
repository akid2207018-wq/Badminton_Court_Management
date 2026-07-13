@extends('layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

<div style="max-width:600px;">

    <div class="card">
        <div class="card-header">&#128100; Edit Profile</div>
        <div class="card-body">

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                               required>
                        @error('name')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               required>
                        @error('email')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number <span style="color:#888;font-weight:normal;">(optional)</span></label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="012-345 6789"
                           class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                    @error('phone')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address <span style="color:#888;font-weight:normal;">(optional)</span></label>
                    <textarea id="address" name="address" rows="3"
                              class="{{ $errors->has('address') ? 'is-invalid' : '' }}"
                              placeholder="Your full address...">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Account Info -->
    <div class="card">
        <div class="card-header">&#128274; Account Information</div>
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td style="color:#666;width:150px;">Member Since</td>
                        <td style="font-weight:bold;">{{ auth()->user()->created_at->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="color:#666;">Total Bookings</td>
                        <td style="font-weight:bold;">{{ auth()->user()->bookings()->count() }}</td>
                    </tr>
                    <tr>
                        <td style="color:#666;">Email</td>
                        <td style="font-weight:bold;">{{ auth()->user()->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
