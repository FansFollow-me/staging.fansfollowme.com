<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Post;
use App\Models\Sale;
use App\Models\Subscription;
use App\Models\Tip;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard.admin', [
            'user' => request()->user(),
            'stats' => $this->stats(),
        ]);
    }

    public function members(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $query = User::with('profile')
            ->latest();

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('username', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        return view('admin.members', [
            'members' => $query->paginate(25)->withQueryString(),
            'q' => $q,
        ]);
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->withErrors(['suspend' => 'Cannot suspend an admin']);
        }

        $user->update(['status' => $user->status === 'active' ? 'suspended' : 'active']);

        return back()->with('status', $user->username.' is now '.$user->status);
    }

    public function posts(Request $request): View
    {
        $posts = Post::with('creator')
            ->latest()
            ->paginate(25);

        return view('admin.posts', compact('posts'));
    }

    public function destroyPost(Request $request, Post $post): RedirectResponse
    {
        $post->delete();

        return back()->with('status', 'Post deleted');
    }

    public function payments(Request $request): View
    {
        $tips = Tip::with('from', 'creator')->latest()->limit(25)->get();
        $sales = Sale::with('buyer', 'creator', 'product')->latest()->limit(25)->get();
        $subscriptions = Subscription::with('fan', 'creator')->latest()->limit(25)->get();
        $deposits = WalletTransaction::where('type', 'deposit')->latest()->limit(25)->get();

        return view('admin.payments', compact('tips', 'sales', 'subscriptions', 'deposits'));
    }

    // Withdrawal admin lives in WithdrawalController (admin.withdrawals.* routes).

    private function stats(): array
    {
        return [
            'users' => User::count(),
            'creators' => User::where('role', UserRole::Creator)->count(),
            'fans' => User::where('role', UserRole::Fan)->count(),
            'posts' => Post::count(),
            'tips_volume' => (int) Tip::sum('amount'),
            'shop_volume' => (int) Sale::where('status', 'completed')->sum('amount'),
            'active_subs' => Subscription::where('status', 'active')->count(),
            'deposits' => (int) WalletTransaction::where('type', 'deposit')->sum('amount'),
            'pending_withdrawals' => \App\Models\WithdrawalRequest::where('status', 'pending')->count(),
        ];
    }
}
