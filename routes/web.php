<?php

use App\Http\Controllers\AgeVerificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('sitemaps.xml', [SitemapController::class, 'index']);
Route::get('sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('sitemap-creators.xml', [SitemapController::class, 'creators'])->name('sitemap.creators');
Route::get('sitemap-fans.xml', [SitemapController::class, 'fans'])->name('sitemap.fans');
Route::get('robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Branded confirmation after UseBasin marketing forms (contact / casting / business)
Route::get('form-thanks', function (\Illuminate\Http\Request $request) {
    $type = (string) $request->query('type', 'contact');
    $map = [
        'contact' => [
            'title' => 'Thanks — message sent | FansFollow.me',
            'headline' => 'Thanks, we got your message',
            'lead' => 'Our team will review what you sent and get back to you as soon as we can. Usually within one business day.',
            'primaryUrl' => route('home'),
            'primaryLabel' => 'Back to home',
            'secondaryUrl' => route('page.support'),
            'secondaryLabel' => 'Visit Support Center',
        ],
        'casting' => [
            'title' => 'Casting waitlist received | FansFollow.me',
            'headline' => 'You’re on the casting waitlist',
            'lead' => 'Thanks for applying. We’ll review your profile and reach out when casting calls open for your specialty.',
            'primaryUrl' => route('page.casting'),
            'primaryLabel' => 'Back to Casting',
            'secondaryUrl' => route('register'),
            'secondaryLabel' => 'Create your profile',
        ],
        'business' => [
            'title' => 'Partnership inquiry sent | FansFollow.me',
            'headline' => 'Thanks — partnership inquiry received',
            'lead' => 'We’ll review your note and follow up within 24 hours about next steps on a partnership conversation.',
            'primaryUrl' => route('page.business'),
            'primaryLabel' => 'Back to Business',
            'secondaryUrl' => route('home'),
            'secondaryLabel' => 'Back to home',
        ],
    ];
    $data = $map[$type] ?? $map['contact'];

    return view('marketing.form-thanks', $data);
})->name('form.thanks');

// Public marketing pages (pretty URLs matching mockup)
foreach ([
    'explore', 'creators', 'fans', 'celebrities', 'casting', 'business',
    'for-creators', 'support', 'faq', 'contact', 'blog', 'privacy',
    'terms', 'cookies', 'live-streams', 'revenue-streams', 'qr-signups',
] as $page) {
    Route::get($page, function (\Illuminate\Http\Request $request) use ($page) {
        return app(HomeController::class)->page($request, $page);
    })->name('page.'.$page);
}

// Auth (guests)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('signup', [AuthController::class, 'showRegister'])->name('register');
    Route::post('signup', [AuthController::class, 'register'])->name('register.attempt');
    Route::get('password/reset', [PasswordResetController::class, 'showRequest'])->name('password.request');
    Route::post('password/reset', [PasswordResetController::class, 'send'])->name('password.email');
    Route::get('password/reset/form', [PasswordResetController::class, 'showReset'])->name('password.reset.form');
    Route::post('password/reset/form', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// QR join
Route::get('j/{code}', [JoinController::class, 'show'])
    ->middleware([\App\Http\Middleware\TrackJoinScan::class])
    ->name('join');

// Post detail — public shell, paid body locked until unlock
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Shop (public browse; buy requires auth)
Route::get('shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('shop/products/{product}', [ShopController::class, 'show'])->name('shop.show');

// Live rooms
Route::get('live', [LiveController::class, 'index'])->name('live.index');
Route::get('live/{room}', [LiveController::class, 'show'])->name('live.show');

// Reels (public feed)
Route::get('reels', [ReelController::class, 'index'])->name('reels.index');
Route::get('reels/{reel}', [ReelController::class, 'show'])->name('reels.show');

// Stories (public feed)
Route::get('stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('stories/{story}', [StoryController::class, 'show'])->name('stories.show');

// Authenticated app — must be registered BEFORE the {username} catch-all
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'fan'])->name('dashboard');
    Route::get('settings/page', [SettingsController::class, 'page'])->name('settings.page');
    Route::put('settings/page', [SettingsController::class, 'updatePage'])->name('settings.page.update');
    Route::get('settings/video-pricing', [SettingsController::class, 'videoPricing'])->name('settings.video-pricing');
    Route::post('settings/video-pricing', [SettingsController::class, 'updateVideoPricing'])->name('settings.video-pricing.update');

    // Money (wallet demo + follow/subscribe/tip/ppv)
    Route::get('my/wallet', [MoneyController::class, 'wallet'])->name('wallet.show');
    Route::post('wallet/add-funds', [MoneyController::class, 'addFunds'])->name('wallet.add-funds');
    Route::post('follow/{creator}', [MoneyController::class, 'follow'])->name('follow');
    Route::delete('follow/{creator}', [MoneyController::class, 'unfollow'])->name('unfollow');
    Route::post('subscribe/{creator}', [MoneyController::class, 'subscribe'])->name('subscribe');
    Route::delete('subscribe/{creator}', [MoneyController::class, 'cancelSubscription'])->name('subscribe.cancel');
    Route::post('tip/{creator}', [MoneyController::class, 'tip'])->name('tip');
    Route::post('posts/{post}/unlock', [MoneyController::class, 'unlockPost'])->name('posts.unlock');
    Route::post('gifts/{tip}/thank', [\App\Http\Controllers\GiftReactionController::class, 'thank'])->name('gifts.thank');
    Route::get('my/gifts', [\App\Http\Controllers\GiftReactionController::class, 'inbox'])->name('gifts.inbox');
    Route::get('gifts/showcase', function () {
        return view('gifts.showcase', [
            'gifts' => \App\Support\TipCatalog::all(),
            'meta' => \App\Support\TipCatalog::jsMap(),
        ]);
    })->name('gifts.showcase');

    // Custom video messages (separate from shop)
    Route::get('video-messages', [\App\Http\Controllers\VideoMessageController::class, 'mine'])->name('video-messages.mine');
    Route::get('video-messages/{videoRequest}', [\App\Http\Controllers\VideoMessageController::class, 'show'])->name('video-messages.show');
    Route::post('video-messages/{videoRequest}/complete', [\App\Http\Controllers\VideoMessageController::class, 'complete'])->name('video-messages.complete');
    Route::post('video-messages/{videoRequest}/reject', [\App\Http\Controllers\VideoMessageController::class, 'reject'])->name('video-messages.reject');
    Route::get('video-messages/{videoRequest}/download', [\App\Http\Controllers\VideoMessageController::class, 'download'])->name('video-messages.download');
    Route::post('video-messages/request/{creator}', [\App\Http\Controllers\VideoMessageController::class, 'store'])->name('video-messages.store');
    Route::get('video-messages/request/{creator}', function (\Illuminate\Http\Request $request, \App\Models\User $creator) {
        abort_unless($creator->isCreator(), 404);

        return view('video-messages.request', compact('creator'));
    })->name('video-messages.request');

    // Messaging
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('messages/{conversation}', [MessageController::class, 'send'])->name('messages.send');
    Route::post('messages/start/{user}', [MessageController::class, 'start'])->name('messages.start');

    // Shop buy / creator manage
    Route::post('shop/products/{product}/buy', [ShopController::class, 'buy'])->name('shop.buy');
    Route::get('shop/sales/{sale}/receipt', [ShopController::class, 'receipt'])->name('shop.receipt');
    Route::get('shop/sales/{sale}/download', [ShopController::class, 'download'])->name('shop.download');
    Route::get('my/purchases', [ShopController::class, 'myPurchases'])->name('shop.purchases');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.readAll');
    Route::get('age/verification', [AgeVerificationController::class, 'show'])->name('age-verification.show');
    Route::post('age/verification', [AgeVerificationController::class, 'store'])->name('age-verification.store');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');

    Route::middleware([EnsureUserHasRole::class.':creator,admin'])->group(function () {
        Route::get('my/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('my/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
        Route::get('creator/dashboard', [DashboardController::class, 'creator'])->name('creator.dashboard');
        Route::get('my/qr', [JoinController::class, 'myQr'])->name('join.my-qr');
        Route::get('my/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('my/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('my/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('my/products', [ShopController::class, 'myProducts'])->name('shop.mine');
        Route::get('add/product', [ShopController::class, 'create'])->name('shop.create');
        Route::post('add/product', [ShopController::class, 'store'])->name('shop.store');
        Route::get('my/live', [LiveController::class, 'create'])->name('live.create');
        Route::post('my/live', [LiveController::class, 'store'])->name('live.store');
        Route::get('my/reels', [ReelController::class, 'mine'])->name('reels.mine');
        Route::get('create/reel', [ReelController::class, 'create'])->name('reels.create');
        Route::post('create/reel', [ReelController::class, 'store'])->name('reels.store');
        Route::get('create/story', [StoryController::class, 'create'])->name('stories.create');
        Route::post('create/story', [StoryController::class, 'store'])->name('stories.store');
        Route::get('my/vault', [VaultController::class, 'index'])->name('vault.index');
        Route::post('my/vault', [VaultController::class, 'store'])->name('vault.store');
        Route::get('my/vault/{item}/download', [VaultController::class, 'download'])->name('vault.download');
        Route::delete('my/vault/{item}', [VaultController::class, 'destroy'])->name('vault.destroy');
        Route::get('my/referrals', [ReferralController::class, 'index'])->name('referrals.index');
        Route::get('my/earnings', [EarningsController::class, 'show'])->name('earnings.show');
        Route::get('my/analytics', [\App\Http\Controllers\AnalyticsController::class, 'show'])->name('analytics.show');
    });

    Route::middleware([EnsureUserHasRole::class.':admin'])->prefix('panel/admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/members', [AdminController::class, 'members'])->name('members');
        Route::post('/members/{user}/suspend', [AdminController::class, 'suspend'])->name('suspend');
        Route::get('/posts', [AdminController::class, 'posts'])->name('posts');
        Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])->name('posts.destroy');
        Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
        Route::get('/withdrawals', [WithdrawalController::class, 'adminIndex'])->name('withdrawals');
        Route::post('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{withdrawal}/reject', [WithdrawalController::class, 'reject'])->name('withdrawals.reject');
        Route::get('/reports', [ReportController::class, 'adminIndex'])->name('reports');
        Route::post('/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');
        Route::get('/feature-requests', [\App\Http\Controllers\AdminInsightController::class, 'featureRequests'])->name('feature-requests');
        Route::get('/gifts', [\App\Http\Controllers\AdminInsightController::class, 'gifts'])->name('gifts');
        Route::post('/reports/{report}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');
    });
});

// Public gift leaderboard
Route::get('{username}/gifts', [\App\Http\Controllers\GiftLeaderboardController::class, 'forCreator'])
    ->where('username', '[A-Za-z0-9_]{3,30}')
    ->name('gifts.leaderboard');

// Coming soon / feature feedback
Route::get('coming-soon', [\App\Http\Controllers\ComingSoonController::class, 'show'])->name('coming-soon');
Route::post('coming-soon/feedback', [\App\Http\Controllers\ComingSoonController::class, 'store'])->name('coming-soon.feedback');

// Public profile — LAST so it never shadows app routes like /dashboard
Route::get('{username}', [HomeController::class, 'profile'])
    ->where('username', '(?!dashboard|login|signup|logout|explore|creators|fans|celebrities|casting|business|for-creators|support|faq|contact|blog|privacy|terms|cookies|live-streams|form-thanks|revenue-streams|posts|settings|panel|j|my|creator|wallet|follow|subscribe|tip|shop|add|messages|reels|stories|create|live|explore|vault|referrals|notifications|gifts|coming-soon)[A-Za-z0-9_]{3,30}')
    ->name('profile');
