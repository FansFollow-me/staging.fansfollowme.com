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

// Create missing tables that Sponzy v7.9.2 expects
try {
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '3306';
    $db   = getenv('DB_DATABASE') ?: 'forge';
    $user = getenv('DB_USERNAME') ?: 'forge';
    $pass = getenv('DB_PASSWORD') ?: '';
    
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    $tables = ['video_calls', 'audio_calls'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() === 0) {
            $pdo->exec("CREATE TABLE $table (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                seller_id INT NOT NULL,
                buyer_id INT NOT NULL,
                price DECIMAL(10,2) DEFAULT 0,
                status VARCHAR(255) DEFAULT 'pending',
                minutes INT DEFAULT 0,
                token VARCHAR(255) NULL,
                started_at TIMESTAMP NULL,
                joined_at TIMESTAMP NULL,
                ended_at TIMESTAMP NULL,
                paid TINYINT(1) DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )");
            echo "Created $table table\n";
        }
    }
    
    // Add missing columns
    $columns = [
        ['table' => 'notifications', 'column' => 'context', 'definition' => 'TEXT DEFAULT NULL'],
        ['table' => 'users', 'column' => 'allow_comments', 'definition' => "VARCHAR(10) DEFAULT 'yes'"],
        ['table' => 'users', 'column' => 'display_list_donors', 'definition' => "VARCHAR(10) DEFAULT 'yes'"],
        ['table' => 'subscriptions', 'column' => 'creator_id', 'definition' => 'INT DEFAULT NULL'],
    ];
    
    foreach ($columns as $col) {
        $stmt = $pdo->query("SHOW COLUMNS FROM `{$col['table']}` LIKE '{$col['column']}'");
        if ($stmt->rowCount() === 0) {
            $pdo->exec("ALTER TABLE `{$col['table']}` ADD COLUMN `{$col['column']}` {$col['definition']}");
            echo "Added {$col['column']} to {$col['table']}\n";
        }
    }
} catch (Exception $e) {
    echo "Schema fix error: " . $e->getMessage() . "\n";
}

// Ensure public access to profiles (not behind login wall)
try {
    $pdo2 = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo2->exec("UPDATE admin_settings SET who_can_see_content = 'everyone' WHERE who_can_see_content = 'users'");
} catch (Exception $e) {}
