<?php
$file = __DIR__.'/app/Providers/ViewServiceProvider.php';
$content = file_get_contents($file);

$old = '$settings = AdminSettings::first();';
$new = <<<'PHP'
$settings = null;
try {
    \DB::connection()->getPdo();
    if (\DB::getSchemaBuilder()->hasTable('admin_settings')) {
        $settings = AdminSettings::first();
    }
} catch (\Exception $e) {}
if (!$settings) {
    $settings = (object)[
        'id' => 1, 'title' => 'FansFollowMe', 'description' => 'Creator Platform for Fitness & Sports',
        'keywords' => 'fitness, creators, sports', 'update_length' => 500, 'status_page' => '1',
        'email_verification' => '0', 'email_no_reply' => '', 'email_admin' => '', 'captcha' => 'off',
        'file_size_allowed' => 100000000, 'google_analytics' => '', 'paypal_account' => '',
        'twitter' => '', 'facebook' => '', 'pinterest' => '', 'instagram' => '',
        'google_adsense' => '', 'currency_symbol' => '$', 'currency_code' => 'USD',
        'min_subscription_amount' => 5, 'payment_gateway' => 'Stripe',
        'min_width_height_image' => '', 'fee_commission' => 20,
        'age_verification_status' => '0', 'age_verification' => '18',
        'navbar_background_color' => '#111827', 'navbar_text_color' => '#ffffff',
        'footer_background_color' => '#111827', 'footer_text_color' => '#d1d5db',
        'show_donate_btn' => 'on', 'show_chat_btn' => 'on',
        'show_badge_blue' => 'on', 'show_badge_gold' => 'on',
        'watermark_status' => 'off', 'watermark_text' => 'FansFollowMe',
        'google_login' => 'on', 'twitter_login' => 'on',
        'apple_login' => 'off', 'meta_pixel' => '',
        'recaptcha_site_key' => '', 'recaptcha_secret_key' => '',
        'smtp_host' => '', 'smtp_port' => '587', 'smtp_username' => '', 'smtp_password' => '',
        'smtp_encryption' => 'tls', 'smtp_from_email' => '', 'smtp_from_name' => 'FansFollowMe',
        'pusher_app_id' => '', 'pusher_app_key' => '', 'pusher_app_secret' => '',
        'pusher_app_cluster' => '', 'twilio_sid' => '', 'twilio_token' => '',
        'twilio_from' => '', 'storage_driver' => 'local', 's3_key' => '', 's3_secret' => '',
        's3_region' => '', 's3_bucket' => '', 's3_url' => '',
        'created_at' => now(), 'updated_at' => now()
    ];
}
PHP;

$content = str_replace($old, $new, $content);
file_put_contents($file, $content);
echo "ViewServiceProvider fixed with comprehensive defaults\n";
