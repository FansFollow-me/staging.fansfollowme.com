@extends('layouts.app')
@section('title', 'Age verification')

@section('content')
<div class="card card-ffm p-4 col-lg-6">
    <h1 class="h3 mb-2">Age verification</h1>
    <p class="text-secondary">Signup records age confirmation only. This step marks verification. Self-declare for now; Yoti/Didit unlock when keys are added.</p>

    @if ($user->age_verified_at)
        <div class="alert alert-success alert-inline">Verified {{ $user->age_verified_at->toFormattedDateString() }} ({{ $user->age_verification_method ?? 'self_declare' }})</div>
    @elseif ($user->age_confirmed_at)
        <div class="alert alert-warning alert-inline">Age confirmed at signup on {{ $user->age_confirmed_at->toFormattedDateString() }} — not yet verified.</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-inline">
            <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('age-verification.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Method</label>
            <select class="form-select" name="method">
                <option value="self_declare">I confirm I am 18 or older</option>
                <option value="yoti" disabled>Yoti (needs keys)</option>
                <option value="didit" disabled>Didit (needs keys)</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="confirm_age" value="1" id="confirm_age" required>
            <label class="form-check-label" for="confirm_age">I confirm this is accurate</label>
        </div>
        <button class="btn btn-ffm" type="submit">Confirm age</button>
        <a class="btn btn-link" href="{{ route('settings.page') }}">Back</a>
    </form>
</div>
@endsection
