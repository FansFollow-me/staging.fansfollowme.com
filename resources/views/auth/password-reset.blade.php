@extends('layouts.app')
@section('title', 'Reset password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-ffm p-4">
            <h1 class="h4 mb-3">Reset password</h1>
            @if ($demoToken)
                <div class="alert alert-info alert-inline small">
                    Demo token (no email yet): <code>{{ $demoToken }}</code>
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success alert-inline">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-inline">
                    <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Token</label>
                    <input class="form-control" name="token" required value="{{ old('token', $demoToken) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">New password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm password</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
                <button class="btn btn-ffm w-100" type="submit">Update password</button>
            </form>
        </div>
    </div>
</div>
@endsection
