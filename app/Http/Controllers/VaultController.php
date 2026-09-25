<?php

namespace App\Http\Controllers;

use App\Models\VaultItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VaultController extends Controller
{
    public function index(Request $request): View
    {
        $items = VaultItem::where('creator_id', $request->user()->id)
            ->latest()
            ->paginate(24);

        return view('vault.index', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:120'],
            'file' => ['required', 'file', 'max:102400'],
        ]);

        $file = $request->file('file');
        $path = \App\Support\UploadStorage::storePrivate($file, 'vault/'.$request->user()->id);

        VaultItem::create([
            'creator_id' => $request->user()->id,
            'title' => $data['title'] ?? $file->getClientOriginalName(),
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
        ]);

        return back()->with('status', 'File saved to vault');
    }

    public function download(Request $request, VaultItem $item): \Symfony\Component\HttpFoundation\Response
    {
        abort_unless($item->creator_id === $request->user()->id || $request->user()->isAdmin(), 403);

        return \App\Support\UploadStorage::response(
            $item->path,
            $item->original_name ?: basename($item->path),
            private: true
        );
    }

    public function destroy(Request $request, VaultItem $item): RedirectResponse
    {
        abort_unless($item->creator_id === $request->user()->id || $request->user()->isAdmin(), 403);

        \App\Support\UploadStorage::delete($item->path);
        $item->delete();

        return back()->with('status', 'File deleted');
    }
}
