@extends('layouts.app')
@section('title', 'My purchases')

@section('content')
<h1 class="h3 mb-4">My purchases</h1>
@if ($sales->isEmpty())
    <p class="text-secondary">Nothing yet. <a href="{{ route('shop.index') }}">Browse shop</a></p>
@else
    <div class="card card-ffm p-3">
        <table class="table table-dark table-sm align-middle mb-0">
            <thead><tr><th>Product</th><th>Seller</th><th>Amount</th><th></th></tr></thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product?->title }}</td>
                        <td>{{ '@'.$sale->creator?->username }}</td>
                        <td>${{ number_format($sale->amount / 100, 2) }}</td>
                        <td>
                            <a href="{{ route('shop.receipt', $sale) }}">Receipt</a>
                            @if ($sale->product?->file_path)
                                · <a href="{{ route('shop.download', $sale) }}">Download</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
