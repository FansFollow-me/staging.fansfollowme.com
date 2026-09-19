@extends('layouts.app')
@section('title', 'Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Creator analytics</h1>
    <a class="btn btn-outline-primary" href="{{ route('creator.dashboard') }}">Studio</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Tips</div>
            <div class="fs-4 fw-bold">${{ number_format($totals['tips'] / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">PPV unlocks</div>
            <div class="fs-4 fw-bold">${{ number_format($totals['ppv'] / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Shop + video</div>
            <div class="fs-4 fw-bold">${{ number_format(($totals['shop'] + $totals['video']) / 100, 2) }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-ffm p-3">
            <div class="text-secondary small">Active subs</div>
            <div class="fs-4 fw-bold">{{ $totals['active_subs'] }}</div>
            <div class="small text-secondary">${{ number_format($totals['sub_revenue'] / 100, 2) }}/mo</div>
        </div>
    </div>
</div>

<div class="card card-ffm p-4 mb-4">
    <h2 class="h6 mb-3">Subscribers (last 8 weeks)</h2>
    @php $maxW = max(1, collect($weeks)->max('new')); @endphp
    <div style="display:flex;align-items:flex-end;gap:6px;height:120px;">
        @foreach ($weeks as $w)
            @php $h = (int) round(($w['new'] / $maxW) * 100); @endphp
            <div title="{{ $w['label'] }} · +{{ $w['new'] }} / -{{ $w['canceled'] }}"
                 style="flex:1;background:linear-gradient(180deg,#f97316,#a855f7);height:{{ max(2, $h) }}px;border-radius:4px 4px 0 0;"></div>
        @endforeach
    </div>
    <div class="d-flex justify-content-between small text-secondary mt-2">
        <span>{{ $weeks->first()['label'] ?? '' }}</span>
        <span>{{ $weeks->last()['label'] ?? '' }}</span>
    </div>
</div>

<div class="card card-ffm p-4 mb-4">
    <h2 class="h6 mb-3">Per-post performance</h2>
    @if ($posts->isEmpty())
        <p class="text-secondary mb-0">No posts yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-sm align-middle mb-0">
                <thead>
                    <tr><th>Post</th><th>Views</th><th>Unlocks</th><th>Revenue</th><th>Conv.</th></tr>
                </thead>
                <tbody>
                    @foreach ($posts as $row)
                        <tr>
                            <td class="small">{{ \Illuminate\Support\Str::limit($row['post']->body, 50) }}</td>
                            <td>{{ $row['views'] }}</td>
                            <td>{{ $row['unlocks'] }}</td>
                            <td class="text-warning">${{ number_format($row['revenue'] / 100, 2) }}</td>
                            <td>{{ $row['conversion'] !== null ? $row['conversion'].'%' : '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<div class="card card-ffm p-4">
    <h2 class="h6 mb-3">Top posts by revenue</h2>
    @php $top = $topRevenue->filter(fn ($r) => $r['revenue'] > 0); @endphp
    @if ($top->isEmpty())
        <p class="text-secondary mb-0">No paid revenue yet.</p>
    @else
        <ol class="mb-0">
            @foreach ($top as $row)
                <li class="mb-1">
                    <strong class="text-warning">${{ number_format($row['revenue'] / 100, 2) }}</strong>
                    — {{ \Illuminate\Support\Str::limit($row['post']->body, 60) }}
                </li>
            @endforeach
        </ol>
    @endif
</div>
@endsection
