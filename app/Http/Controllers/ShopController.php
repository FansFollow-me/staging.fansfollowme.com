<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Services\WalletService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShopController extends Controller
{
    public function __construct(private WalletService $wallets)
    {
    }

    public function index(Request $request): View
    {
        $products = Product::with('creator.profile')
            ->where('is_active', true)
            ->latest()
            ->paginate(24);

        return view('shop.index', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load('creator.profile');

        return view('shop.show', compact('product'));
    }

    public function myProducts(Request $request): View
    {
        $products = Product::where('creator_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('shop.mine', compact('products'));
    }

    public function create(): View
    {
        return view('shop.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'integer', 'min:100', 'max:10000000'],
            'file' => ['nullable', 'file', 'max:51200'],
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = \App\Support\UploadStorage::storePrivate($request->file('file'), 'products');
        }

        Product::create([
            'creator_id' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'price' => (int) $data['price'],
            'currency' => 'USD',
            'type' => 'digital',
            'file_path' => $path,
            'is_active' => true,
        ]);

        return redirect()
            ->route('shop.mine')
            ->with('status', 'Product published');
    }

    public function buy(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        if ($user->id === $product->creator_id) {
            return back()->withErrors(['buy' => 'You cannot buy your own product']);
        }

        if (! $product->isAvailable()) {
            return back()->withErrors(['buy' => 'Product unavailable']);
        }

        $already = Sale::where('product_id', $product->id)
            ->where('buyer_id', $user->id)
            ->where('status', 'completed')
            ->exists();

        if ($already) {
            return back()->with('status', 'You already own this');
        }

        $amount = max(0, (int) $product->price);

        try {
            $this->wallets->debit($user, $amount, 'shop_purchase', 'product', $product->id);
        } catch (\RuntimeException $e) {
            return back()->withErrors(['buy' => 'Add funds to your wallet first']);
        }

        $this->wallets->credit($product->creator, $amount, 'shop_earning', 'product', $product->id);

        $sale = Sale::create([
            'product_id' => $product->id,
            'buyer_id' => $user->id,
            'creator_id' => $product->creator_id,
            'amount' => $amount,
            'currency' => 'USD',
            'status' => 'completed',
            'provider' => 'wallet',
            'download_token' => Str::random(40),
        ]);

        if ($product->stock !== null) {
            $product->decrement('stock');
        }

        app(\App\Services\NotificationService::class)->pushNotificationById(
            (int) $product->creator_id,
            'sale',
            'Sale: '.$product->title,
            'Bought by @'.$user->username.' for $'.number_format($amount / 100, 2)
        );
        app(\App\Services\NotificationService::class)->pushNotificationById((int) $user->id, 'purchase', 'Purchase complete', $product->title);

        return redirect()
            ->route('shop.receipt', $sale)
            ->with('status', 'Purchase complete');
    }

    public function receipt(Request $request, Sale $sale): View
    {
        abort_unless($sale->buyer_id === $request->user()->id || $sale->creator_id === $request->user()->id, 403);

        return view('shop.receipt', [
            'sale' => $sale->load('product', 'buyer', 'creator'),
        ]);
    }

    public function download(Request $request, Sale $sale): \Symfony\Component\HttpFoundation\Response
    {
        abort_unless($sale->buyer_id === $request->user()->id, 403);
        abort_unless($sale->status === 'completed', 403);

        $product = $sale->product;
        abort_unless($product && $product->file_path, 404);

        $sale->forceFill(['downloaded_at' => now()])->save();

        return \App\Support\UploadStorage::response(
            $product->file_path,
            basename($product->file_path),
            private: true
        );
    }

    public function myPurchases(Request $request): View
    {
        $sales = Sale::with('product', 'creator')
            ->where('buyer_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('shop.purchases', compact('sales'));
    }
}

