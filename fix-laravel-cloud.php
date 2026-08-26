<?php
// Fix ViewServiceProvider for Laravel Cloud (no local DB during build)
$file = __DIR__.'/app/Providers/ViewServiceProvider.php';
$content = file_get_contents($file);

// Wrap the AdminSettings::first() call in a table existence check
$content = str_replace(
    '$settings = AdminSettings::first();',
    '$settings = (\\DB::getSchemaBuilder()->hasTable("admin_settings") ? AdminSettings::first() : null) ?? (object)["title" => "FansFollowMe", "description" => "Creator Platform for Fitness & Sports", "currency_symbol" => "$", "currency_code" => "USD", "navbar_background_color" => "#111827", "navbar_text_color" => "#ffffff", "footer_background_color" => "#111827", "footer_text_color" => "#d1d5db", "status_page" => "1", "fee_commission" => 20];',
    $content
);

file_put_contents($file, $content);
echo "ViewServiceProvider fixed for Laravel Cloud\n";
