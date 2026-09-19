@extends('layouts.app')
@section('title', 'Vault')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Vault</h1>
    <a class="btn btn-outline-primary" href="{{ route('creator.dashboard') }}">Studio</a>
</div>
@if (session('status'))
    <div class="alert alert-success alert-inline">{{ session('status') }}</div>
@endif

<div class="card card-ffm p-4 mb-4">
    <h2 class="h6">Upload file</h2>
    <form method="POST" action="{{ route('vault.store') }}" enctype="multipart/form-data" class="row g-2 align-items-end">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Title (optional)</label>
            <input class="form-control" name="title" maxlength="120">
        </div>
        <div class="col-md-5">
            <label class="form-label">File (max 100MB)</label>
            <input class="form-control" type="file" name="file" required>
            @error('file')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-3">
            <button class="btn btn-ffm w-100" type="submit">Save to vault</button>
        </div>
    </form>
</div>

@if ($items->isEmpty())
    <p class="text-secondary">Vault is empty. Store workout plans, meal PDFs, private assets.</p>
@else
    <div class="card card-ffm p-3">
        <table class="table table-dark table-sm align-middle mb-0">
            <thead><tr><th>Title</th><th>Size</th><th>Uploaded</th><th></th></tr></thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ number_format($item->size_bytes / 1024, 1) }} KB</td>
                        <td class="small text-secondary">{{ $item->created_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <a class="small" href="{{ route('vault.download', $item) }}">Download</a>
                            <form method="POST" action="{{ route('vault.destroy', $item) }}" class="d-inline ms-2" onsubmit="return confirm('Delete file?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $items->links() }}</div>
@endif
@endsection
