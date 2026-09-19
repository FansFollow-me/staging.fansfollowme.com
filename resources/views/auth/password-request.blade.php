@extends('layouts.app')
@section('title', 'Forgot password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card card-ffm p-4">
            <h1 class="h4 mb-3">Forgot password</h1>
            @if (session('status'))
                <div class="alert alert-success alert-inline">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" required value="{{ old('email') }}">
                </div>
                <button class="btn btn-ffm w-100" type="submit">Send reset link</button>
            </form>
            <p class="small text-secondary mt-3 mb-0"><a href="{{ route('login') }}">Back to login</a></p>
        </div>
    </div>
</div>
@endsection
