@extends('layouts.app')
@section('title', 'Admin · Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Reports</h1>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-inline">
        <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="card card-ffm p-3">
    <table class="table table-dark table-sm align-middle mb-0">
        <thead>
            <tr><th>Reporter</th><th>Target</th><th>Reason</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td>{{ '@'.$report->reporter?->username }}</td>
                    <td class="small">{{ $report->subject_type }} #{{ $report->subject_id }}</td>
                    <td>{{ $report->reason }}</td>
                    <td>
                        <span class="badge text-bg-{{ $report->status === 'open' ? 'warning' : 'secondary' }}">{{ $report->status }}</span>
                    </td>
                    <td class="text-end">
                        @if ($report->status === 'open')
                            <form method="POST" action="{{ route('admin.reports.resolve', $report) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="dismiss">
                                <button class="btn btn-sm btn-outline-secondary" type="submit">Dismiss</button>
                            </form>
                            @if ($report->subject_type === 'post')
                                <form method="POST" action="{{ route('admin.reports.resolve', $report) }}" class="d-inline ms-1">
                                    @csrf
                                    <input type="hidden" name="action" value="remove_content">
                                    <button class="btn btn-sm btn-outline-warning" type="submit">Remove post</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.reports.resolve', $report) }}" class="d-inline ms-1">
                                @csrf
                                <input type="hidden" name="action" value="suspend_user">
                                <button class="btn btn-sm btn-outline-danger" type="submit">Suspend user</button>
                            </form>
                        @else
                            <span class="small text-secondary">{{ $report->admin_note }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-secondary">No reports.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $reports->links() }}</div>
@endsection
