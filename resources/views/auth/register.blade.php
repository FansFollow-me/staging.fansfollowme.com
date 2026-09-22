@extends('layouts.app')
@section('title', 'Sign up')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card card-ffm p-4">
            <h1 class="h4 mb-3">Join FansFollow.me</h1>
            @if (session('join_code'))
                <div class="alert alert-info alert-inline py-2 small">You joined via a creator QR code.</div>
            @endif
            <form method="POST" action="{{ route('register.attempt') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">I am a</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="role-fan" value="fan" {{ old('role', 'fan') === 'fan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-fan">Fan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="role-creator" value="creator" {{ old('role') === 'creator' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role-creator">Creator</label>
                        </div>
                    </div>
                    @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required>
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                    @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">Confirm password</label>
                    <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label" for="terms">I agree to the <a href="{{ route('page.terms') }}">Terms</a></label>
                </div>
                <button class="btn btn-ffm w-100" type="submit">Create account</button>
            </form>
        </div>
    </div>
</div>
@endsection
