@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card card-ffm p-4">
            <h1 class="h4 mb-3">Welcome back</h1>
            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="username_email">Email or username</label>
                    <input class="form-control" id="username_email" name="username_email" type="text" required autofocus value="{{ old('username_email') }}">
                    @error('username_email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control" id="password" name="password" type="password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button class="btn btn-ffm w-100" type="submit">Login</button>
            </form>
            <p class="small text-secondary mt-3 mb-0">
                New here? <a href="{{ route('register') }}">Create an account</a>
            </p>
        </div>
    </div>
</div>
@endsection
