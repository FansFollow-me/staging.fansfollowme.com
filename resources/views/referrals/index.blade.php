@extends('layouts.app')
@section('title', 'Referrals')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Referrals</h1>
    <a class="btn btn-outline-primary" href="{{ route('creator.dashboard') }}">Studio</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Referred users</div>
            <div class="fs-3 fw-bold">{{ $count }}</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-ffm p-3">
            <div class="text-secondary small mb-1">Your referral link</div>
            <code class="d-block mb-2" style="word-break:break-all;">{{ $signupUrl }}</code>
            <button class="btn btn-sm btn-ffm" type="button" onclick="navigator.clipboard.writeText(@js($signupUrl))">Copy link</button>
        </div>
    </div>
</div>

<div class="card card-ffm p-3">
    <h2 class="h6">People who joined via you</h2>
    @if ($referred->isEmpty())
        <p class="text-secondary mb-0">No referrals yet. Share your link or QR at the gym.</p>
    @else
        <table class="table table-dark table-sm mb-0">
            <thead><tr><th>User</th><th>Joined</th></tr></thead>
            <tbody>
                @foreach ($referred as $person)
                    <tr>
                        <td>{{ '@'.$person->username }}</td>
                        <td class="small text-secondary">{{ $person->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">{{ $referred->links() }}</div>
    @endif
</div>
@endsection
