<?php

namespace App\Providers;

use App\Helper;
use App\Models\Gift;
use App\Models\Reel;
use App\Models\Blogs;
use App\Models\Reports;
use App\Models\Updates;
use App\Models\Deposits;
use App\Models\TaxRates;
use App\Models\Languages;
use App\Models\Categories;
use App\Models\Advertising;
use App\Models\Withdrawals;
use App\Models\AdminSettings;
use App\Models\LiveStreamings;
use App\Models\PaymentGateways;
use App\Models\VerificationRequests;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot()
    {
        // Always provide defaults first
        $settings = (object)[
            'title' => 'FansFollowMe',
            'description' => 'Creator Platform for Fitness & Sports',
            'keywords' => 'fitness, creators, sports, martial arts',
            'currency_symbol' => '$',
            'currency_code' => 'USD',
            'min_subscription_amount' => 5,
            'fee_commission' => 20,
            'file_size_allowed' => 100000000,
            'status_page' => '1',
            'email_verification' => '0',
            'captcha' => 'off',
            'payment_gateway' => 'Stripe',
            'navbar_background_color' => '#111827',
            'navbar_text_color' => '#ffffff',
            'footer_background_color' => '#111827',
            'footer_text_color' => '#d1d5db',
        ];
        $updatesPendingCount = 0;
        $depositsPendingCount = 0;
        $reports = 0;
        $withdrawalsPendingCount = 0;
        $verificationRequestsCount = 0;
        $paymentsGateways = collect([]);
        $paymentGatewaysSubscription = collect([]);
        $blogsCount = 0;
        $categoriesCount = 0;
        $categoriesFooter = collect([]);
        $languages = collect([]);
        $taxRatesCount = 0;
        $showSectionMyCards = false;
        $getCurrentLiveCreators = [];
        $advertising = collect([]);
        $gifts = collect([]);
        $reelsPublic = 0;

        try {
            \DB::connection()->getPdo();
            if (\DB::getSchemaBuilder()->hasTable('admin_settings')) {
                $dbSettings = AdminSettings::first();
                if ($dbSettings) {
                    foreach ($dbSettings->attributesToArray() as $key => $value) {
                        $settings->$key = $value;
                    }
                }
                $updatesPendingCount = Updates::selectRaw('COUNT(id) as total')->whereStatus('pending')->pluck('total')->first() ?? 0;
                $depositsPendingCount = Deposits::selectRaw('COUNT(id) as total')->whereStatus('pending')->pluck('total')->first() ?? 0;
                $reports = Reports::selectRaw('COUNT(id) as total')->pluck('total')->first() ?? 0;
                $withdrawalsPendingCount = Withdrawals::selectRaw('COUNT(id) as total')->whereStatus('pending')->pluck('total')->first() ?? 0;
                $verificationRequestsCount = VerificationRequests::selectRaw('COUNT(id) as total')->whereStatus('pending')->pluck('total')->first() ?? 0;
                $paymentsGateways = PaymentGateways::all();
                $paymentGatewaysSubscription = PaymentGateways::where('enabled', '1')->whereSubscription('yes')->get();
                $blogsCount = Blogs::count();
                $categoriesCount = Categories::count();
                $categoriesFooter = Categories::where('mode', 'on')->orderBy('name')->take(6)->get();
                $languages = Languages::orderBy('name')->get();
                $taxRatesCount = TaxRates::whereStatus('1')->count();
                $showSectionMyCards = Helper::showSectionMyCards();
                $getCurrentLiveCreators = LiveStreamings::whereType('normal')
                    ->where('updated_at', '>', now()->subMinutes(5))
                    ->whereStatus('0')
                    ->pluck('user_id')
                    ->toArray();
                $advertising = Advertising::where('expired_at', '>', now())
                    ->whereStatus(1)
                    ->inRandomOrder()
                    ->take(1)
                    ->get();
                $gifts = Gift::whereStatus(true)->orderBy('price', 'asc')->get();
                $reelsPublic = Reel::whereStatus('active')->whereType('public')->count();
            }
        } catch (\Exception $e) {
            // DB unavailable — use defaults
        }

        view()->share(
            compact(
                'settings',
                'updatesPendingCount',
                'depositsPendingCount',
                'reports',
                'withdrawalsPendingCount',
                'verificationRequestsCount',
                'paymentsGateways',
                'blogsCount',
                'categoriesCount',
                'categoriesFooter',
                'languages',
                'taxRatesCount',
                'showSectionMyCards',
                'getCurrentLiveCreators',
                'advertising',
                'gifts',
                'reelsPublic'
            )
        );
    }
}
// build cache bust 1787777810
