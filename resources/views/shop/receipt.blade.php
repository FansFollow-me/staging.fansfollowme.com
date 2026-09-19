@extends('layouts.app')
@section('title', 'Receipt')

@section('content')
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif
<div class="card card-ffm p-4 col-lg-6">
    <h1 class="h3">Purchase complete</h1>
    <p class="mb-1"><strong>{{ $sale->product->title }}</strong></p>
    <p class="text-secondary">${{ number_format($sale->amount / 100, 2) }} · {{ $sale->created_at->toDayDateTimeString() }}</p>
    @if ($sale->product->file_path && auth()->id() === $sale->buyer_id)
        <a class="btn btn-ffm" href="{{ route('shop.download', $sale) }}">Download file</a>
    @endif
    <a class="btn btn-outline-primary" href="{{ route('shop.index') }}">Back to shop</a>
</div>
@endsection
